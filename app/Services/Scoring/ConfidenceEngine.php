<?php

namespace App\Services\Scoring;

use App\Models\CategoryTemplate;
use App\Models\MethodologyVersion;
use App\Models\ReviewAggregate;
use App\Models\Tool;

/**
 * TA Evidence Confidence Engine — Module E
 *
 * Calculates evidence confidence (0–100) and High/Moderate/Low label.
 * Confidence is SEPARATE from product quality — a product can score well
 * with Moderate Confidence; confidence describes how much current,
 * corroborated evidence supports the evaluation.
 *
 * Component weights:
 *  Core criterion evidence coverage  40%
 *  Independent corroboration         25%
 *  Evidence freshness                20%
 *  Customer evidence sufficiency     15%
 */
class ConfidenceEngine
{
    // Component weights from spec §6
    private const COMPONENT_WEIGHTS = [
        'core_coverage'    => 0.40,
        'corroboration'    => 0.25,
        'freshness'        => 0.20,
        'customer_evidence'=> 0.15,
    ];

    // Thresholds: High ≥ 80; Moderate 60–79; Low < 60
    private const THRESHOLDS = ['high' => 80, 'moderate' => 60];

    /**
     * Calculate confidence for a product against a category template.
     *
     * @param  Tool              $tool
     * @param  CategoryTemplate  $template
     * @param  array             $evidenceItems   Raw array of EvidenceItem records
     * @return array{ score: float, label: string, breakdown: array }
     */
    public function calculate(Tool $tool, CategoryTemplate $template, array $evidenceItems): array
    {
        $methodology   = MethodologyVersion::current();
        $thresholds    = $methodology
            ? ($methodology->getGlobalParam('confidence_thresholds') ?? self::THRESHOLDS)
            : self::THRESHOLDS;

        $breakdown = [];

        // -----------------------------------------------------------------------
        // 1. Core criterion evidence coverage (40%)
        //    % of required scoring inputs with at least one valid evidence item
        // -----------------------------------------------------------------------
        $coreCoverage = $this->computeCoreCoverage($tool, $template, $evidenceItems);
        $breakdown['core_coverage'] = $coreCoverage;

        // -----------------------------------------------------------------------
        // 2. Independent corroboration (25%)
        //    % of critical product claims corroborated by a 2nd independent source
        // -----------------------------------------------------------------------
        $corroboration = $this->computeCorroboration($evidenceItems);
        $breakdown['corroboration'] = $corroboration;

        // -----------------------------------------------------------------------
        // 3. Evidence freshness (20%)
        //    Weighted freshness vs configured TTLs
        // -----------------------------------------------------------------------
        $freshness = $this->computeFreshness($evidenceItems);
        $breakdown['freshness'] = $freshness;

        // -----------------------------------------------------------------------
        // 4. Customer evidence sufficiency (15%)
        //    Volume / recency / source breadth
        // -----------------------------------------------------------------------
        $customerSufficiency = $this->computeCustomerSufficiency($tool);
        $breakdown['customer_evidence'] = $customerSufficiency;

        // Weighted sum
        $score = 0.0;
        foreach (self::COMPONENT_WEIGHTS as $component => $weight) {
            $score += ($breakdown[$component] ?? 0) * $weight;
        }
        $score = round(min(100, max(0, $score)), 2);

        // Determine label
        $label = 'Low';
        if ($score >= ($thresholds['high'] ?? 80)) {
            $label = 'High';
        } elseif ($score >= ($thresholds['moderate'] ?? 60)) {
            $label = 'Moderate';
        }

        return [
            'score'     => $score,
            'label'     => $label,
            'breakdown' => $breakdown,
        ];
    }

    // =========================================================================
    // COMPONENT CALCULATORS
    // =========================================================================

    /**
     * Core coverage: % of core requirements + critical scoring inputs that have
     * at least one verified or unverified (not stale) evidence item.
     */
    private function computeCoreCoverage(Tool $tool, CategoryTemplate $template, array $evidenceItems): float
    {
        $coreReqs = $template->core_requirements ?? [];
        if (empty($coreReqs)) {
            return 70.0; // unknown template → give moderate default
        }

        $coveredKeys = collect($evidenceItems)
            ->where('verified_status', '!=', 'stale')
            ->pluck('field_key')
            ->map(fn($k) => strtolower($k))
            ->unique()
            ->toArray();

        $covered = 0;
        foreach ($coreReqs as $req) {
            $expectedKey = 'core_cap_' . strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9\s]/', '', $req)));
            if (in_array($expectedKey, $coveredKeys, true)) {
                $covered++;
            }
        }

        $pct = count($coreReqs) > 0 ? ($covered / count($coreReqs)) * 100 : 70.0;
        return round($pct, 2);
    }

    /**
     * Corroboration: % of evidence items that have a corresponding item from a
     * DIFFERENT source family confirming the same field_key.
     */
    private function computeCorroboration(array $evidenceItems): float
    {
        if (empty($evidenceItems)) {
            return 0.0;
        }

        // Group by field_key → list of source families
        $byField = [];
        foreach ($evidenceItems as $item) {
            $key = $item['field_key'] ?? '';
            if ($key === '') {
                continue;
            }
            $family = $item['source_family'] ?? $item['source_id'] ?? 'unknown';
            $byField[$key][] = $family;
        }

        $totalFields    = count($byField);
        $corroborated   = 0;

        foreach ($byField as $key => $families) {
            $uniqueFamilies = array_unique($families);
            if (count($uniqueFamilies) >= 2) {
                $corroborated++;
            }
        }

        return $totalFields > 0 ? round(($corroborated / $totalFields) * 100, 2) : 0.0;
    }

    /**
     * Freshness: weighted average of evidence item freshness.
     * Pricing TTL = 30 days; security docs = 90 days; general = 60 days.
     */
    private function computeFreshness(array $evidenceItems): float
    {
        if (empty($evidenceItems)) {
            return 0.0;
        }

        $ttlMap = [
            'pricing'  => 30,
            'security' => 90,
            'default'  => 60,
        ];

        $total    = 0;
        $weighted = 0;

        foreach ($evidenceItems as $item) {
            $retrievedAt = isset($item['retrieved_at']) ? \Carbon\Carbon::parse($item['retrieved_at']) : null;
            if (!$retrievedAt) {
                continue;
            }

            $ageInDays = $retrievedAt->diffInDays(now());
            $fieldKey  = strtolower($item['field_key'] ?? '');

            $ttl = $ttlMap['default'];
            if (str_contains($fieldKey, 'pricing') || str_contains($fieldKey, 'price')) {
                $ttl = $ttlMap['pricing'];
            } elseif (str_contains($fieldKey, 'security') || str_contains($fieldKey, 'compliance')) {
                $ttl = $ttlMap['security'];
            }

            $freshness  = max(0, 1 - ($ageInDays / $ttl));
            $weighted  += $freshness;
            $total++;
        }

        return $total > 0 ? round(($weighted / $total) * 100, 2) : 0.0;
    }

    /**
     * Customer evidence sufficiency: volume + source breadth + recency.
     */
    private function computeCustomerSufficiency(Tool $tool): float
    {
        $aggregates = ReviewAggregate::where('tool_id', $tool->id)->get();

        if ($aggregates->isEmpty()) {
            return 0.0; // confidence reduced; product uses category prior for score
        }

        // Source breadth (unique families, capped at 3 for full score)
        $families     = $aggregates->pluck('source_family')->unique()->count();
        $breadthScore = min(100, ($families / 3) * 100);

        // Volume (total reviews; 100+ = full score)
        $totalReviews = $aggregates->sum('review_count');
        $volumeScore  = min(100, ($totalReviews / 100) * 100);

        // Recency (has any data from last 12 months)
        $recentCount = 0;
        foreach ($aggregates as $agg) {
            $recency = $agg->recency_data ?? [];
            $recentCount += ($recency['0_6'] ?? 0) + ($recency['6_12'] ?? 0);
        }
        $recencyScore = $recentCount > 0 ? min(100, ($recentCount / 20) * 100) : 0;

        return round(($breadthScore + $volumeScore + $recencyScore) / 3, 2);
    }
}
