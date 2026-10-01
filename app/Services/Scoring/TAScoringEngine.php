<?php

namespace App\Services\Scoring;

use App\Models\CategoryTemplate;
use App\Models\EvidenceItem;
use App\Models\MethodologyVersion;
use App\Models\ProductFact;
use App\Models\ReviewAggregate;
use App\Models\ReviewException;
use App\Models\ScoreBreakdown;
use App\Models\ScoreRun;
use App\Models\ScoringAuditLog;
use App\Models\Tool;
use Illuminate\Support\Facades\DB;

/**
 * TA Scoring Engine — Deterministic Scoring Service (v1.0)
 *
 * BUILD PRINCIPLE:
 *  - AI may collect and structure evidence; this engine calculates the TA Score.
 *  - The AI model must never assign the final score directly.
 *  - The same structured inputs + methodology version = identical output.
 *
 * FORMULA:
 *  TA_internal (0–100) = Σ(dimension_score × dimension_weight)
 *  Public TA Score      = round(TA_internal / 10, 1)   → 0.0–10.0
 */
class TAScoringEngine
{
    /** Dimension keys in order */
    public const DIMENSIONS = [
        'use_case_fit',
        'ai_utility',
        'usability',
        'workflow_fit',
        'value_pricing',
        'trust_readiness',
        'customer_evidence',
        'product_health',
    ];

    /** v1.0 default weights (must always sum to 1.0) */
    public const DEFAULT_WEIGHTS = [
        'use_case_fit'      => 0.25,
        'ai_utility'        => 0.15,
        'usability'         => 0.15,
        'workflow_fit'      => 0.10,
        'value_pricing'     => 0.10,
        'trust_readiness'   => 0.10,
        'customer_evidence' => 0.10,
        'product_health'    => 0.05,
    ];

    /** Maximum internal points per dimension (summing to 100) */
    public const DIMENSION_MAX = [
        'use_case_fit'      => 25,
        'ai_utility'        => 15,
        'usability'         => 15,
        'workflow_fit'      => 10,
        'value_pricing'     => 10,
        'trust_readiness'   => 10,
        'customer_evidence' => 10,
        'product_health'    => 5,
    ];

    private MethodologyVersion $methodology;
    private CategoryTemplate $template;
    private array $facts;
    private array $evidenceItems;
    private ConfidenceEngine $confidenceEngine;

    public function __construct(ConfidenceEngine $confidenceEngine)
    {
        $this->confidenceEngine = $confidenceEngine;
    }

    // =========================================================================
    // PUBLIC API
    // =========================================================================

    /**
     * Score a product for a specific category.
     *
     * @param  Tool                $tool
     * @param  int                 $categoryId
     * @param  bool                $dryRun       If true, returns result without persisting.
     * @param  bool                $publish       Publish the run immediately.
     * @return array{score_run: ScoreRun|null, result: array}
     */
    public function score(Tool $tool, int $categoryId, bool $dryRun = false, bool $publish = false): array
    {
        // Load methodology and template
        $this->methodology = MethodologyVersion::current()
            ?? $this->createDefaultMethodology();

        $this->template = CategoryTemplate::activeForCategory($categoryId)
            ?? $this->createDefaultTemplate($categoryId);

        // Load facts and evidence
        $this->facts = ProductFact::where('tool_id', $tool->id)
            ->get()
            ->keyBy('field_key')
            ->toArray();

        $this->evidenceItems = EvidenceItem::where('tool_id', $tool->id)
            ->where('verified_status', '!=', 'stale')
            ->get()
            ->toArray();

        // Score each dimension
        $dimensionScores = [];
        $breakdowns      = [];

        foreach (self::DIMENSIONS as $dim) {
            [$score, $dimBreakdowns] = $this->scoreDimension($dim, $tool, $categoryId);
            $dimensionScores[$dim]   = $score;
            $breakdowns[$dim]        = $dimBreakdowns;
        }

        // Weighted sum (internal 0–100)
        $internalScore = $this->computeWeightedSum($dimensionScores);

        // Public TA Score (0.0–10.0, 1 decimal)
        $publicScore = round($internalScore / 10, 1);

        // Confidence
        $confidence = $this->confidenceEngine->calculate($tool, $this->template, $this->evidenceItems);

        // Rank eligibility
        $status = $this->determineStatus($confidence, $tool);

        $result = [
            'tool_id'            => $tool->id,
            'category_id'        => $categoryId,
            'methodology_version'=> $this->methodology->version_name,
            'template_version'   => $this->template->template_version,
            'dimension_scores'   => $dimensionScores,
            'internal_score'     => $internalScore,
            'public_score'       => $publicScore,
            'confidence_score'   => $confidence['score'],
            'confidence_label'   => $confidence['label'],
            'status'             => $status,
            'breakdowns'         => $breakdowns,
        ];

        if ($dryRun) {
            return ['score_run' => null, 'result' => $result];
        }

        $scoreRun = $this->persist($tool, $categoryId, $result, $breakdowns, $publish);

        // Check exception triggers
        $this->checkExceptionTriggers($tool, $categoryId, $scoreRun);

        ScoringAuditLog::record('ScoreRun', $scoreRun->id, 'create', null, [
            'public_score'    => $publicScore,
            'confidence_label'=> $confidence['label'],
            'status'          => $status,
        ]);

        return ['score_run' => $scoreRun, 'result' => $result];
    }

    // =========================================================================
    // DIMENSION SCORERS
    // =========================================================================

    private function scoreDimension(string $dimension, Tool $tool, int $categoryId): array
    {
        return match ($dimension) {
            'use_case_fit'      => $this->scoreUseCaseFit(),
            'ai_utility'        => $this->scoreAiUtility(),
            'usability'         => $this->scoreUsability(),
            'workflow_fit'      => $this->scoreWorkflowFit(),
            'value_pricing'     => $this->scoreValuePricing(),
            'trust_readiness'   => $this->scoreTrustReadiness(),
            'customer_evidence' => $this->scoreCustomerEvidence($tool, $categoryId),
            'product_health'    => $this->scoreProductHealth(),
            default             => [0.0, []],
        };
    }

    // -------------------------------------------------------------------------
    // 3.1 Use-Case Fit & Capability Depth — 25 points total
    // -------------------------------------------------------------------------
    private function scoreUseCaseFit(): array
    {
        $breakdowns = [];
        $coreReqs   = $this->template->core_requirements ?? [];
        $advancedCaps = $this->template->advanced_capabilities ?? [];

        // Sub-criterion 1: Core capability coverage — 15 pts
        // Based on how many core requirements have verified product facts.
        $coveredCore = 0;
        $totalCore   = max(1, count($coreReqs));
        foreach ($coreReqs as $req) {
            $key   = 'core_cap_' . \Str::slug($req, '_');
            $value = $this->factValue($key);
            if ($value !== null && $value !== '0' && $value !== 'false' && $value !== '') {
                $coveredCore++;
            }
        }
        // Also check generic capability_count as partial fallback
        $capCount = (int)($this->factValue('capability_count') ?? 0);
        $coverage = $coveredCore / $totalCore;
        // Partial credit via capability count if core caps are not individually tracked
        if ($coveredCore === 0 && $capCount > 0) {
            $coverage = min(0.7, $capCount / 10);
        }
        $corePts = round($coverage * 15, 2);
        $breakdowns[] = [
            'subcriterion_key' => 'core_capability_coverage',
            'raw_value'        => $coverage,
            'points_awarded'   => $corePts,
            'max_points'       => 15,
            'reasoning'        => "Covered {$coveredCore}/{$totalCore} core requirements.",
        ];

        // Sub-criterion 2: Capability depth — 7 pts
        $depthScore = (float)($this->factValue('capability_depth_score') ?? 0);   // 0–100 from admin
        $depthPts   = round(($depthScore / 100) * 7, 2);
        $breakdowns[] = [
            'subcriterion_key' => 'capability_depth',
            'raw_value'        => $depthScore,
            'points_awarded'   => $depthPts,
            'max_points'       => 7,
            'reasoning'        => "Admin-assessed depth score: {$depthScore}/100.",
        ];

        // Sub-criterion 3: Differentiating functionality — 3 pts
        $coveredAdv = 0;
        $totalAdv   = max(1, count($advancedCaps));
        foreach ($advancedCaps as $cap) {
            $key = 'adv_cap_' . \Str::slug($cap, '_');
            if ($this->factBool($key)) {
                $coveredAdv++;
            }
        }
        $advCoverage = $coveredAdv / $totalAdv;
        $advPts      = round($advCoverage * 3, 2);
        $breakdowns[] = [
            'subcriterion_key' => 'differentiating_functionality',
            'raw_value'        => $advCoverage,
            'points_awarded'   => $advPts,
            'max_points'       => 3,
            'reasoning'        => "Covered {$coveredAdv}/{$totalAdv} advanced capabilities.",
        ];

        $total = $corePts + $depthPts + $advPts;
        return [$total, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.2 AI Utility & Product Depth — 15 points total
    // -------------------------------------------------------------------------
    private function scoreAiUtility(): array
    {
        $breakdowns = [];
        $aiDepthDef = $this->template->ai_depth_definition ?? '';

        // AI relevance to core workflow — 5 pts
        $relevance = (float)($this->factValue('ai_relevance_score') ?? 0);
        $pts1      = round(($relevance / 100) * 5, 2);
        $breakdowns[] = ['subcriterion_key' => 'ai_relevance', 'raw_value' => $relevance, 'points_awarded' => $pts1, 'max_points' => 5, 'reasoning' => "AI relevance: {$relevance}/100"];

        // AI capability depth — 5 pts
        $aiDepth = (float)($this->factValue('ai_capability_depth_score') ?? 0);
        $pts2    = round(($aiDepth / 100) * 5, 2);
        $breakdowns[] = ['subcriterion_key' => 'ai_capability_depth', 'raw_value' => $aiDepth, 'points_awarded' => $pts2, 'max_points' => 5, 'reasoning' => "AI depth: {$aiDepth}/100"];

        // Control, transparency & guardrails — 3 pts
        $control = (float)($this->factValue('ai_control_score') ?? 0);
        $pts3    = round(($control / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'ai_control_transparency', 'raw_value' => $control, 'points_awarded' => $pts3, 'max_points' => 3, 'reasoning' => "Control/transparency: {$control}/100"];

        // AI differentiation — 2 pts
        $diff = (float)($this->factValue('ai_differentiation_score') ?? 0);
        $pts4 = round(($diff / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'ai_differentiation', 'raw_value' => $diff, 'points_awarded' => $pts4, 'max_points' => 2, 'reasoning' => "Differentiation: {$diff}/100"];

        return [$pts1 + $pts2 + $pts3 + $pts4, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.3 Usability & Time to Value — 15 points total
    // -------------------------------------------------------------------------
    private function scoreUsability(): array
    {
        $breakdowns = [];

        // Onboarding & setup burden — 4 pts
        $onboard = (float)($this->factValue('onboarding_score') ?? 0);
        $pts1    = round(($onboard / 100) * 4, 2);
        $breakdowns[] = ['subcriterion_key' => 'onboarding_setup', 'raw_value' => $onboard, 'points_awarded' => $pts1, 'max_points' => 4, 'reasoning' => "Onboarding: {$onboard}/100"];

        // Workflow clarity & learning curve — 4 pts
        $clarity = (float)($this->factValue('workflow_clarity_score') ?? 0);
        $pts2    = round(($clarity / 100) * 4, 2);
        $breakdowns[] = ['subcriterion_key' => 'workflow_clarity', 'raw_value' => $clarity, 'points_awarded' => $pts2, 'max_points' => 4, 'reasoning' => "Workflow clarity: {$clarity}/100"];

        // Time to first useful outcome — 4 pts
        $ttv  = (float)($this->factValue('time_to_value_score') ?? 0);
        $pts3 = round(($ttv / 100) * 4, 2);
        $breakdowns[] = ['subcriterion_key' => 'time_to_value', 'raw_value' => $ttv, 'points_awarded' => $pts3, 'max_points' => 4, 'reasoning' => "TTV: {$ttv}/100"];

        // Adoption support — 3 pts
        $support = (float)($this->factValue('adoption_support_score') ?? 0);
        $pts4    = round(($support / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'adoption_support', 'raw_value' => $support, 'points_awarded' => $pts4, 'max_points' => 3, 'reasoning' => "Adoption support: {$support}/100"];

        return [$pts1 + $pts2 + $pts3 + $pts4, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.4 Workflow & Integration Fit — 10 points total
    // -------------------------------------------------------------------------
    private function scoreWorkflowFit(): array
    {
        $breakdowns    = [];
        $importantInts = $this->template->important_integrations ?? [];

        // Required integration coverage — 4 pts
        $coveredInts = 0;
        $totalInts   = max(1, count($importantInts));
        foreach ($importantInts as $int) {
            $key = 'integration_' . \Str::slug($int, '_');
            if ($this->factBool($key)) {
                $coveredInts++;
            }
        }
        // Fallback: generic integration_count
        $intCount = (int)($this->factValue('integration_count') ?? 0);
        $intCoverage = ($coveredInts > 0 || count($importantInts) === 0)
            ? $coveredInts / $totalInts
            : min(0.6, $intCount / max(1, $totalInts * 3));

        $pts1 = round($intCoverage * 4, 2);
        $breakdowns[] = ['subcriterion_key' => 'integration_coverage', 'raw_value' => $intCoverage, 'points_awarded' => $pts1, 'max_points' => 4, 'reasoning' => "Covered {$coveredInts}/{$totalInts} integrations."];

        // Extensibility & interoperability — 3 pts
        $hasApi     = $this->factBool('has_api')     ? 1 : 0;
        $hasWebhook = $this->factBool('has_webhooks') ? 1 : 0;
        $hasExport  = $this->factBool('has_data_export') ? 1 : 0;
        $extScore   = (float)($this->factValue('extensibility_score') ?? (($hasApi + $hasWebhook + $hasExport) / 3 * 100));
        $pts2       = round(($extScore / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'extensibility', 'raw_value' => $extScore, 'points_awarded' => $pts2, 'max_points' => 3, 'reasoning' => "API:{$hasApi} Webhooks:{$hasWebhook} Export:{$hasExport}"];

        // Team/workflow fit — 3 pts
        $teamFit = (float)($this->factValue('team_workflow_fit_score') ?? 0);
        $pts3    = round(($teamFit / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'team_workflow_fit', 'raw_value' => $teamFit, 'points_awarded' => $pts3, 'max_points' => 3, 'reasoning' => "Team/workflow fit: {$teamFit}/100"];

        return [$pts1 + $pts2 + $pts3, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.5 Value & Pricing — 10 points total
    // -------------------------------------------------------------------------
    private function scoreValuePricing(): array
    {
        $breakdowns = [];

        // Pricing transparency — 3 pts
        $hasPublicPricing = $this->factBool('pricing_public');
        $hasClearTerms    = $this->factBool('pricing_terms_clear');
        $transparencyScore = ($hasPublicPricing ? 70 : 20) + ($hasClearTerms ? 30 : 0);
        $pricingTransScore = (float)($this->factValue('pricing_transparency_score') ?? $transparencyScore);
        $pts1 = round(($pricingTransScore / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'pricing_transparency', 'raw_value' => $pricingTransScore, 'points_awarded' => $pts1, 'max_points' => 3, 'reasoning' => "Public:{$hasPublicPricing} Terms:{$hasClearTerms}"];

        // Entry value — 2 pts
        $entryValue = (float)($this->factValue('entry_value_score') ?? 0);
        $pts2       = round(($entryValue / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'entry_value', 'raw_value' => $entryValue, 'points_awarded' => $pts2, 'max_points' => 2, 'reasoning' => "Entry value: {$entryValue}/100"];

        // Capability-to-price value — 3 pts
        $valueScore = (float)($this->factValue('capability_price_value_score') ?? 0);
        $pts3       = round(($valueScore / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'capability_price_value', 'raw_value' => $valueScore, 'points_awarded' => $pts3, 'max_points' => 3, 'reasoning' => "Cap/price value: {$valueScore}/100"];

        // Commercial flexibility — 2 pts
        $hasTrial   = $this->factBool('has_free_trial');
        $hasMonthly = $this->factBool('has_monthly_billing');
        $flexScore  = ($hasTrial ? 50 : 0) + ($hasMonthly ? 50 : 0);
        $commercialFlex = (float)($this->factValue('commercial_flexibility_score') ?? $flexScore);
        $pts4       = round(($commercialFlex / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'commercial_flexibility', 'raw_value' => $commercialFlex, 'points_awarded' => $pts4, 'max_points' => 2, 'reasoning' => "Trial:{$hasTrial} Monthly:{$hasMonthly}"];

        return [$pts1 + $pts2 + $pts3 + $pts4, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.6 Trust & Business Readiness — 10 points total
    // -------------------------------------------------------------------------
    private function scoreTrustReadiness(): array
    {
        $breakdowns = [];

        // Privacy & data practices — 2 pts
        $hasPrivacyPolicy = $this->factBool('has_privacy_policy');
        $hasDataDeletion  = $this->factBool('has_data_deletion');
        $privacyBase      = ($hasPrivacyPolicy ? 60 : 0) + ($hasDataDeletion ? 40 : 0);
        $privacyScore     = (float)($this->factValue('privacy_score') ?? $privacyBase);
        $pts1 = round(($privacyScore / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'privacy_data', 'raw_value' => $privacyScore, 'points_awarded' => $pts1, 'max_points' => 2, 'reasoning' => "Privacy: {$privacyScore}/100"];

        // Security & administration — 3 pts
        // Spec: do NOT make SOC2/ISO27001 universal requirements
        $secScore = (float)($this->factValue('security_score') ?? 0);
        $pts2     = round(($secScore / 100) * 3, 2);
        $breakdowns[] = ['subcriterion_key' => 'security_admin', 'raw_value' => $secScore, 'points_awarded' => $pts2, 'max_points' => 3, 'reasoning' => "Security: {$secScore}/100"];

        // Reliability & operational readiness — 2 pts
        $hasStatusPage = $this->factBool('has_status_page');
        $hasSupport    = $this->factBool('has_support_channel');
        $reliabilityBase = ($hasStatusPage ? 50 : 0) + ($hasSupport ? 50 : 0);
        $reliabilityScore = (float)($this->factValue('reliability_score') ?? $reliabilityBase);
        $pts3 = round(($reliabilityScore / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'reliability', 'raw_value' => $reliabilityScore, 'points_awarded' => $pts3, 'max_points' => 2, 'reasoning' => "Status:{$hasStatusPage} Support:{$hasSupport}"];

        // Governance / responsible AI — 2 pts
        $govScore = (float)($this->factValue('governance_score') ?? 0);
        $pts4     = round(($govScore / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'governance_ai', 'raw_value' => $govScore, 'points_awarded' => $pts4, 'max_points' => 2, 'reasoning' => "Governance: {$govScore}/100"];

        // Business readiness for target segment — 1 pt
        $bizReady = (float)($this->factValue('business_readiness_score') ?? 0);
        $pts5     = round(($bizReady / 100) * 1, 2);
        $breakdowns[] = ['subcriterion_key' => 'business_readiness', 'raw_value' => $bizReady, 'points_awarded' => $pts5, 'max_points' => 1, 'reasoning' => "Business readiness: {$bizReady}/100"];

        return [$pts1 + $pts2 + $pts3 + $pts4 + $pts5, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.7 Customer Evidence — 10 points total (Bayesian-adjusted)
    // -------------------------------------------------------------------------
    private function scoreCustomerEvidence(Tool $tool, int $categoryId): array
    {
        $breakdowns = [];
        $methodology = $this->methodology;

        // v1.0 config
        $bayesianM    = $methodology->getGlobalParam('bayesian_m', 20);
        $recencyWeights = $methodology->getGlobalParam('recency_weights', [
            '0_6'   => 1.00,
            '6_12'  => 0.85,
            '12_18' => 0.65,
            '18_24' => 0.45,
        ]);

        // Category prior (average normalised rating of ranked products in category)
        $categoryPrior = $this->getCategoryPrior($categoryId);

        // Independent source families (Capterra/GetApp/Software Advice = ONE family: gartner_digital_markets)
        $aggregates = ReviewAggregate::where('tool_id', $tool->id)->get();

        // Deduplicate by source family
        $byFamily = $aggregates->keyBy('source_family');

        $adjustedRatings = [];
        $totalWeightedCount = 0;

        foreach ($byFamily as $family => $agg) {
            $n        = $agg->review_count;
            $rating   = $agg->rating_norm ?? $categoryPrior;  // 0–100

            // Bayesian adjustment
            $adjustedRating = (($n / ($n + $bayesianM)) * $rating)
                + (($bayesianM / ($n + $bayesianM)) * $categoryPrior);

            // Recency weight from recency_data breakdown
            $recencyWeight = $this->computeRecencyWeight($agg->recency_data ?? [], $recencyWeights);
            $effectiveN    = $n * $recencyWeight;

            $adjustedRatings[$family] = [
                'adjusted' => $adjustedRating,
                'weight'   => $effectiveN,
            ];
            $totalWeightedCount += $effectiveN;
        }

        // Weighted average across source families (cap any single family at 60% weight)
        if ($totalWeightedCount > 0) {
            $weightedSum = 0;
            foreach ($adjustedRatings as $family => $data) {
                $familyShare = min(0.6, $data['weight'] / $totalWeightedCount);
                $weightedSum += $data['adjusted'] * $familyShare;
            }
            // Normalise if caps reduced total
            $totalShare = 0;
            foreach ($adjustedRatings as $family => $data) {
                $totalShare += min(0.6, $data['weight'] / $totalWeightedCount);
            }
            $adjustedExternalRating = $totalShare > 0 ? $weightedSum / $totalShare : $categoryPrior;
        } else {
            // No external reviews — use category prior; reduce confidence later
            $adjustedExternalRating = $categoryPrior;
        }

        // Sub-criterion 1: Adjusted external rating — 6 pts
        $pts1 = round(($adjustedExternalRating / 100) * 6, 2);
        $breakdowns[] = ['subcriterion_key' => 'adjusted_external_rating', 'raw_value' => $adjustedExternalRating, 'points_awarded' => $pts1, 'max_points' => 6, 'reasoning' => "Bayesian-adjusted across " . $byFamily->count() . " source families. Category prior: {$categoryPrior}"];

        // Sub-criterion 2: Recency — 1.5 pts
        $overallRecency = $this->computeOverallRecency($aggregates->pluck('recency_data')->toArray(), $recencyWeights);
        $pts2 = round($overallRecency * 1.5, 2);
        $breakdowns[] = ['subcriterion_key' => 'recency', 'raw_value' => $overallRecency, 'points_awarded' => $pts2, 'max_points' => 1.5, 'reasoning' => "Recency weight: {$overallRecency}"];

        // Sub-criterion 3: Independent-source consistency — 1.5 pts
        $consistency = $this->computeSourceConsistency($adjustedRatings);
        $pts3 = round($consistency * 1.5, 2);
        $breakdowns[] = ['subcriterion_key' => 'source_consistency', 'raw_value' => $consistency, 'points_awarded' => $pts3, 'max_points' => 1.5, 'reasoning' => "Consistency across families: {$consistency}"];

        // Sub-criterion 4: Recurring customer themes — 1 pt
        $themes     = $this->factValue('customer_theme_score') ?? '50';
        $themePts   = round((float)$themes / 100, 2);
        $pts4       = round($themePts * 1, 2);
        $breakdowns[] = ['subcriterion_key' => 'customer_themes', 'raw_value' => (float)$themes, 'points_awarded' => $pts4, 'max_points' => 1, 'reasoning' => "Theme score: {$themes}/100"];

        $total = min(10, $pts1 + $pts2 + $pts3 + $pts4); // never exceed 10 pts
        return [$total, $breakdowns];
    }

    // -------------------------------------------------------------------------
    // 3.8 Product Health & Momentum — 5 points total
    // -------------------------------------------------------------------------
    private function scoreProductHealth(): array
    {
        $breakdowns = [];

        // Maintenance/activity — 2 pts
        $hasRecentRelease = $this->factBool('has_release_last_12m');
        $hasMaintainedDocs = $this->factBool('has_maintained_docs');
        $activityBase     = ($hasRecentRelease ? 60 : 0) + ($hasMaintainedDocs ? 40 : 0);
        $activityScore    = (float)($this->factValue('maintenance_activity_score') ?? $activityBase);
        $pts1 = round(($activityScore / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'maintenance_activity', 'raw_value' => $activityScore, 'points_awarded' => $pts1, 'max_points' => 2, 'reasoning' => "RecentRelease:{$hasRecentRelease} MaintainedDocs:{$hasMaintainedDocs}"];

        // Meaningful product progress — 2 pts
        $progressScore = (float)($this->factValue('product_progress_score') ?? 0);
        $pts2          = round(($progressScore / 100) * 2, 2);
        $breakdowns[] = ['subcriterion_key' => 'product_progress', 'raw_value' => $progressScore, 'points_awarded' => $pts2, 'max_points' => 2, 'reasoning' => "Progress: {$progressScore}/100"];

        // Platform continuity — 1 pt
        $isAbandoned    = $this->factBool('is_abandoned');
        $isBroken       = $this->factBool('is_core_broken');
        $continuityBase = ($isAbandoned || $isBroken) ? 0 : 100;
        $continuityScore = (float)($this->factValue('platform_continuity_score') ?? $continuityBase);
        $pts3 = round(($continuityScore / 100) * 1, 2);
        $breakdowns[] = ['subcriterion_key' => 'platform_continuity', 'raw_value' => $continuityScore, 'points_awarded' => $pts3, 'max_points' => 1, 'reasoning' => "Abandoned:{$isAbandoned} Broken:{$isBroken}"];

        return [$pts1 + $pts2 + $pts3, $breakdowns];
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    /**
     * Compute internal weighted sum 0–100.
     * TA_internal = Σ(dimension_score × weight × 100 / max_points_for_dim)
     *
     * Since each dimension is already scored on 0..max_points (e.g. use_case_fit on 0..25),
     * we normalise each to 0–100 first then multiply by its weight, then sum (gives 0–100).
     */
    private function computeWeightedSum(array $dimensionScores): float
    {
        $total   = 0.0;
        $weights = $this->methodology->weights ?? self::DEFAULT_WEIGHTS;

        foreach ($dimensionScores as $dim => $rawScore) {
            $max    = self::DIMENSION_MAX[$dim] ?? 1;
            $weight = $weights[$dim] ?? (self::DEFAULT_WEIGHTS[$dim] ?? 0);
            // Normalise dimension to 0–100 then weight
            $total += ($rawScore / $max) * 100 * $weight;
        }

        return round(min(100, max(0, $total)), 4);
    }

    private function factValue(string $key): ?string
    {
        return isset($this->facts[$key]) ? ($this->facts[$key]['value'] ?? null) : null;
    }

    private function factBool(string $key): bool
    {
        $v = $this->factValue($key);
        return in_array(strtolower((string)$v), ['1', 'true', 'yes', 'on'], true);
    }

    private function getCategoryPrior(int $categoryId): float
    {
        // Average normalised rating of all published tools in this category
        $prior = ReviewAggregate::whereHas('tool.categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        })->avg('rating_norm');

        // Global fallback: use configured global prior or 65.0
        return round($prior ?? $this->methodology->getGlobalParam('global_review_prior', 65.0), 2);
    }

    private function computeRecencyWeight(array $recencyData, array $weights): float
    {
        if (empty($recencyData)) {
            return $weights['18_24'] ?? 0.45;
        }
        $total   = 0;
        $weighted = 0;
        foreach ([
            '0_6'   => $weights['0_6']   ?? 1.00,
            '6_12'  => $weights['6_12']  ?? 0.85,
            '12_18' => $weights['12_18'] ?? 0.65,
            '18_24' => $weights['18_24'] ?? 0.45,
        ] as $bucket => $w) {
            $count     = $recencyData[$bucket] ?? 0;
            $weighted += $count * $w;
            $total    += $count;
        }
        return $total > 0 ? round($weighted / $total, 4) : ($weights['18_24'] ?? 0.45);
    }

    private function computeOverallRecency(array $recencyDataArr, array $weights): float
    {
        $allRecency = [];
        foreach ($recencyDataArr as $rd) {
            if (is_array($rd)) {
                $allRecency = array_merge_recursive($allRecency, $rd);
            }
        }
        $merged = [];
        foreach (['0_6', '6_12', '12_18', '18_24'] as $bucket) {
            $merged[$bucket] = is_array($allRecency[$bucket] ?? null)
                ? array_sum($allRecency[$bucket])
                : (int)($allRecency[$bucket] ?? 0);
        }
        return $this->computeRecencyWeight($merged, $weights);
    }

    private function computeSourceConsistency(array $adjustedRatings): float
    {
        if (count($adjustedRatings) < 2) {
            return 0.7; // single source — moderate consistency by default
        }
        $values = array_column($adjustedRatings, 'adjusted');
        $max    = max($values);
        $min    = min($values);
        $spread = $max - $min; // 0 = perfect consistency, 100 = maximally inconsistent

        // Consistency score: 0 spread → 1.0; 30+ spread → 0.0
        return max(0, round(1 - ($spread / 30), 4));
    }

    private function determineStatus(array $confidence, Tool $tool): string
    {
        $minConfidenceForRanked = $this->methodology->getGlobalParam('min_confidence_for_ranking', 60);
        $confidenceScore = $confidence['score'];

        if ($confidenceScore >= $minConfidenceForRanked) {
            return 'ranked';
        }

        if ($confidenceScore >= 30) {
            return 'provisional';
        }

        return 'unranked';
    }

    // =========================================================================
    // PERSISTENCE
    // =========================================================================

    private function persist(Tool $tool, int $categoryId, array $result, array $breakdowns, bool $publish): ScoreRun
    {
        return DB::transaction(function () use ($tool, $categoryId, $result, $breakdowns, $publish) {
            $scoreRun = ScoreRun::create([
                'tool_id'                => $tool->id,
                'category_id'            => $categoryId,
                'methodology_version_id' => $this->methodology->id,
                'template_version'       => $this->template->template_version,
                'run_at'                 => now(),
                'internal_score'         => $result['internal_score'],
                'public_score'           => $result['public_score'],
                'confidence_score'       => $result['confidence_score'],
                'confidence_label'       => $result['confidence_label'],
                'status'                 => $result['status'],
                'is_published'           => $publish,
            ]);

            foreach ($breakdowns as $dimKey => $dimBreakdowns) {
                foreach ($dimBreakdowns as $bd) {
                    ScoreBreakdown::create([
                        'score_run_id'     => $scoreRun->id,
                        'dimension_key'    => $dimKey,
                        'subcriterion_key' => $bd['subcriterion_key'],
                        'raw_value'        => $bd['raw_value'] ?? null,
                        'points_awarded'   => $bd['points_awarded'],
                        'max_points'       => $bd['max_points'],
                        'rule_version'     => $this->methodology->version_name,
                        'reasoning'        => $bd['reasoning'] ?? null,
                    ]);
                }
            }

            return $scoreRun;
        });
    }

    // =========================================================================
    // EXCEPTION TRIGGER DETECTION
    // =========================================================================

    /**
     * Spec section 9: only exceptions require founder review.
     */
    private function checkExceptionTriggers(Tool $tool, int $categoryId, ScoreRun $newRun): void
    {
        $triggers = [];

        // Previous published run
        $prevRun = ScoreRun::where('tool_id', $tool->id)
            ->where('category_id', $categoryId)
            ->where('is_published', true)
            ->where('id', '!=', $newRun->id)
            ->latest('run_at')
            ->first();

        if ($prevRun) {
            $delta = abs($newRun->public_score - $prevRun->public_score);
            if ($delta >= 0.7) {
                $triggers[] = [
                    'type'        => 'score_change',
                    'severity'    => 'high',
                    'description' => "TA Score changed by {$delta} points (was {$prevRun->public_score}, now {$newRun->public_score}).",
                ];
            }

            // Rank position change ≥5 (check latest rank snapshot)
            $prevRank = \App\Models\RankSnapshot::where('category_id', $categoryId)
                ->where('tool_id', $tool->id)
                ->latest('snapshot_date')
                ->value('rank');

            $currentRank = \App\Models\RankSnapshot::where('category_id', $categoryId)
                ->latest('snapshot_date')
                ->first();

            if ($prevRank && $currentRank) {
                $rankDelta = abs($currentRank->rank - $prevRank);
                if ($rankDelta >= 5) {
                    $triggers[] = [
                        'type'        => 'rank_jump',
                        'severity'    => 'medium',
                        'description' => "Rank changed by {$rankDelta} positions.",
                    ];
                }
            }
        }

        // Confidence drop below 60
        if ($newRun->confidence_score < 60) {
            $triggers[] = [
                'type'        => 'confidence_drop',
                'severity'    => 'medium',
                'description' => "Evidence Confidence fell to {$newRun->confidence_score} (below 60 threshold).",
            ];
        }

        // Top 10 entry (first time appearing in top 10 ranked)
        $rank = \App\Models\RankSnapshot::where('category_id', $categoryId)
            ->where('tool_id', $tool->id)
            ->latest('snapshot_date')
            ->value('rank');

        if ($rank && $rank <= 10 && (!$prevRun || $prevRun->public_score < 7.0)) {
            $triggers[] = [
                'type'        => 'top_10_entry',
                'severity'    => 'high',
                'description' => "Product entered category Top 10 for the first time at rank #{$rank}.",
            ];
        }

        foreach ($triggers as $trigger) {
            ReviewException::create([
                'tool_id'     => $tool->id,
                'score_run_id'=> $newRun->id,
                'trigger_type'=> $trigger['type'],
                'severity'    => $trigger['severity'],
                'description' => $trigger['description'],
                'status'      => 'open',
            ]);
        }

        if (!empty($triggers)) {
            $newRun->update(['flagged_for_review' => true]);
        }
    }

    // =========================================================================
    // DEFAULT SEEDS (used when no methodology/template exists yet)
    // =========================================================================

    private function createDefaultMethodology(): MethodologyVersion
    {
        return MethodologyVersion::create([
            'version_name'       => 'TA Score v1.0',
            'weights'            => self::DEFAULT_WEIGHTS,
            'global_parameters'  => [
                'bayesian_m'             => 20,
                'recency_window_months'  => 24,
                'recency_weights'        => [
                    '0_6'   => 1.00,
                    '6_12'  => 0.85,
                    '12_18' => 0.65,
                    '18_24' => 0.45,
                ],
                'confidence_thresholds'  => ['high' => 80, 'moderate' => 60],
                'min_confidence_for_ranking' => 60,
                'min_core_evidence_coverage' => 0.70,
                'large_score_change_threshold' => 0.7,
                'global_review_prior'    => 65.0,
                'public_score_decimals'  => 1,
                'rank_publication_cadence' => 'monthly',
            ],
            'effective_date'     => now(),
            'published_at'       => now(),
            'is_active'          => true,
        ]);
    }

    private function createDefaultTemplate(int $categoryId): CategoryTemplate
    {
        return CategoryTemplate::create([
            'category_id'                  => $categoryId,
            'template_version'             => 'v1.0-default',
            'effective_date'               => now(),
            'core_requirements'            => ['Core feature 1', 'Core feature 2', 'Core feature 3'],
            'advanced_capabilities'        => [],
            'important_integrations'       => [],
            'target_segments'              => ['smb'],
            'trust_requirements'           => [],
            'ai_depth_definition'          => 'AI that materially improves the core workflow.',
            'pricing_comparison_basis'     => ['type' => 'seat_based'],
            'minimum_evidence_requirements'=> ['core_coverage_pct' => 0.70],
            'manual_review_triggers'       => [],
            'is_active'                    => true,
        ]);
    }
}
