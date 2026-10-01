<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTemplate;
use App\Models\EvidenceItem;
use App\Models\EvidenceSource;
use App\Models\MethodologyVersion;
use App\Models\ProductFact;
use App\Models\ReviewAggregate;
use App\Models\ReviewException;
use App\Models\ScoreRun;
use App\Models\ScoringAuditLog;
use App\Models\Tool;
use App\Models\VendorCorrection;
use App\Services\Scoring\ConfidenceEngine;
use App\Services\Scoring\RankingService;
use App\Services\Scoring\TAScoringEngine;
use Illuminate\Http\Request;

class ScoringController extends Controller
{
    public function __construct(
        private TAScoringEngine $scoringEngine,
        private RankingService  $rankingService,
        private ConfidenceEngine $confidenceEngine,
    ) {}

    // =========================================================================
    // SCORING DASHBOARD
    // =========================================================================

    public function dashboard()
    {
        $stats = [
            'awaiting_first_score'    => Tool::published()
                ->whereDoesntHave('scoreRuns')
                ->count(),
            'successful_runs'         => ScoreRun::where('is_published', true)->count(),
            'failed_runs'             => ScoreRun::where('flagged_for_review', true)->count(),
            'provisional_products'    => ScoreRun::where('status', 'provisional')
                ->where('is_published', true)
                ->distinct('tool_id')
                ->count(),
            'open_exceptions'         => ReviewException::where('status', 'open')->count(),
            'pending_corrections'     => VendorCorrection::where('status', 'pending')->count(),
        ];

        $recentRuns = ScoreRun::with(['tool', 'category'])
            ->latest('run_at')
            ->take(10)
            ->get();

        $highImpactExceptions = ReviewException::with(['tool'])
            ->whereIn('severity', ['high', 'critical'])
            ->where('status', 'open')
            ->latest()
            ->take(5)
            ->get();

        return view('backend.admin.scoring.dashboard', compact('stats', 'recentRuns', 'highImpactExceptions'));
    }

    // =========================================================================
    // SCORE A PRODUCT (admin trigger)
    // =========================================================================

    public function scoreProduct(Request $request)
    {
        $validated = $request->validate([
            'tool_id'     => 'required|exists:tools,id',
            'category_id' => 'required|exists:categories,id',
            'dry_run'     => 'boolean',
            'publish'     => 'boolean',
        ]);

        $tool     = Tool::findOrFail($validated['tool_id']);
        $dryRun   = $validated['dry_run'] ?? false;
        $publish  = $validated['publish'] ?? false;

        $result = $this->scoringEngine->score(
            $tool,
            $validated['category_id'],
            $dryRun,
            $publish
        );

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        $msg = $dryRun
            ? "Dry-run complete. TA Score would be {$result['result']['public_score']}."
            : "Score run complete. TA Score: {$result['result']['public_score']}.";

        return redirect()->route('admin.scoring.show', $result['score_run']?->id ?? 0)
            ->with('success', $msg);
    }

    /**
     * Score all published tools in a category.
     */
    public function scoreCategory(Request $request, Category $category)
    {
        $publish = $request->boolean('publish', false);
        $tools   = $category->tools()->where('status', 'published')->get();
        $results = [];

        foreach ($tools as $tool) {
            $result    = $this->scoringEngine->score($tool, $category->id, false, $publish);
            $results[] = [
                'tool'         => $tool->name,
                'public_score' => $result['result']['public_score'],
                'confidence'   => $result['result']['confidence_label'],
                'status'       => $result['result']['status'],
            ];
        }

        if ($publish) {
            $this->rankingService->publishCategoryRanks($category->id);
        }

        if ($request->expectsJson()) {
            return response()->json(['results' => $results, 'count' => count($results)]);
        }

        return redirect()->route('admin.scoring.dashboard')
            ->with('success', count($results) . " tools scored in \"{$category->name}\".");
    }

    // =========================================================================
    // SCORE DETAIL VIEW
    // =========================================================================

    public function show(ScoreRun $scoreRun)
    {
        $scoreRun->load(['tool', 'category', 'methodologyVersion', 'breakdowns', 'exceptions']);

        $dimensionSummary = $scoreRun->getDimensionSummary();

        $history = ScoreRun::where('tool_id', $scoreRun->tool_id)
            ->where('category_id', $scoreRun->category_id)
            ->where('is_published', true)
            ->orderBy('run_at')
            ->get(['id', 'run_at', 'public_score', 'confidence_label', 'status']);

        $rank = $this->rankingService->getCurrentRank($scoreRun->tool_id, $scoreRun->category_id);

        $productFacts = ProductFact::where('tool_id', $scoreRun->tool_id)->get();
        $evidenceSources = EvidenceSource::where('tool_id', $scoreRun->tool_id)->get();

        return view('backend.admin.scoring.show', compact(
            'scoreRun', 'dimensionSummary', 'history', 'rank', 'productFacts', 'evidenceSources'
        ));
    }

    /**
     * List all score runs for a tool.
     */
    public function toolHistory(Tool $tool)
    {
        $runs = ScoreRun::where('tool_id', $tool->id)
            ->with(['category', 'methodologyVersion'])
            ->latest('run_at')
            ->paginate(20);

        return view('backend.admin.scoring.tool-history', compact('tool', 'runs'));
    }

    // =========================================================================
    // PUBLISH / UNPUBLISH RUNS
    // =========================================================================

    public function publish(ScoreRun $scoreRun)
    {
        if ($scoreRun->flagged_for_review) {
            return back()->with('error', 'This score run is flagged for review and cannot be published until exceptions are resolved.');
        }

        $scoreRun->update(['is_published' => true]);

        ScoringAuditLog::record('ScoreRun', $scoreRun->id, 'publish', null, ['is_published' => true]);

        return back()->with('success', 'Score run published successfully.');
    }

    public function unpublish(ScoreRun $scoreRun)
    {
        $scoreRun->update(['is_published' => false]);
        ScoringAuditLog::record('ScoreRun', $scoreRun->id, 'unpublish', null, ['is_published' => false]);

        return back()->with('success', 'Score run unpublished.');
    }

    // =========================================================================
    // EXCEPTION QUEUE
    // =========================================================================

    public function exceptions(Request $request)
    {
        $query = ReviewException::with(['tool', 'scoreRun'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }
        if ($request->filled('trigger_type')) {
            $query->where('trigger_type', $request->trigger_type);
        }

        $exceptions = $query->paginate(20)->withQueryString();

        return view('backend.admin.scoring.exceptions', compact('exceptions'));
    }

    public function resolveException(Request $request, ReviewException $exception)
    {
        $validated = $request->validate([
            'status'     => 'required|in:resolved,dismissed',
            'resolution' => 'nullable|string|max:1000',
        ]);

        $before = $exception->only(['status', 'resolution']);

        $exception->update([
            'status'      => $validated['status'],
            'resolution'  => $validated['resolution'] ?? null,
            'owner'       => auth()->user()->name,
            'resolved_at' => now(),
        ]);

        ScoringAuditLog::record('ReviewException', $exception->id, 'resolve', $before, $exception->fresh()->toArray());

        return back()->with('success', 'Exception ' . $validated['status'] . '.');
    }

    // =========================================================================
    // PRODUCT FACTS MANAGEMENT
    // =========================================================================

    public function facts(Tool $tool)
    {
        $productFacts    = ProductFact::where('tool_id', $tool->id)->get();
        $evidenceSources = EvidenceSource::where('tool_id', $tool->id)->with('evidenceItems')->get();
        $categories      = $tool->categories;

        return view('backend.admin.scoring.facts', compact('tool', 'productFacts', 'evidenceSources', 'categories'));
    }

    public function updateFact(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'field_key'    => 'required|string|max:191',
            'value'        => 'nullable|string',
            'status'       => 'required|in:verified,unverified,disputed',
            'reason'       => 'nullable|string|max:500',
        ]);

        $existing = ProductFact::where('tool_id', $tool->id)
            ->where('field_key', $validated['field_key'])
            ->first();

        $before = $existing?->toArray();

        $fact = ProductFact::setFor(
            $tool->id,
            $validated['field_key'],
            $validated['value'],
            [],
            $validated['status']
        );

        ScoringAuditLog::record(
            'ProductFact',
            $fact->id,
            $before ? 'update' : 'create',
            $before,
            $fact->toArray(),
            $validated['reason'] ?? null
        );

        return back()->with('success', "Fact '{$validated['field_key']}' updated.");
    }

    public function deleteFact(Request $request, Tool $tool, ProductFact $fact)
    {
        $before = $fact->toArray();
        $fact->delete();

        ScoringAuditLog::record('ProductFact', $fact->id, 'delete', $before, null, $request->reason);

        return back()->with('success', 'Fact deleted.');
    }

    // =========================================================================
    // EVIDENCE SOURCES
    // =========================================================================

    public function storeEvidenceSource(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'source_type'        => 'required|string',
            'source_family'      => 'required|string',
            'url'                => 'required|url',
            'authority_level'    => 'required|in:primary,secondary,corroborating',
            'allowed_usage_mode' => 'required|in:aggregate_only,full,manual_entry',
            'refresh_ttl_days'   => 'nullable|integer|min:1',
        ]);

        $source = EvidenceSource::create(array_merge($validated, ['tool_id' => $tool->id]));

        ScoringAuditLog::record('EvidenceSource', $source->id, 'create', null, $source->toArray());

        return back()->with('success', 'Evidence source added.');
    }

    public function storeEvidenceItem(Request $request, EvidenceSource $source)
    {
        $validated = $request->validate([
            'field_key'            => 'required|string|max:191',
            'extracted_value'      => 'nullable|string',
            'raw_excerpt'          => 'nullable|string',
            'extractor_confidence' => 'nullable|numeric|min:0|max:1',
            'verified_status'      => 'required|in:unverified,verified,conflicting,stale',
            'expires_at'           => 'nullable|date',
        ]);

        $item = EvidenceItem::create(array_merge($validated, [
            'source_id'   => $source->id,
            'tool_id'     => $source->tool_id,
            'retrieved_at'=> now(),
        ]));

        ScoringAuditLog::record('EvidenceItem', $item->id, 'create', null, $item->toArray());

        return back()->with('success', 'Evidence item added.');
    }

    // =========================================================================
    // REVIEW AGGREGATES
    // =========================================================================

    public function storeReviewAggregate(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'source_family' => 'required|string',
            'rating_raw'    => 'nullable|numeric|min:0|max:5',
            'rating_norm'   => 'nullable|numeric|min:0|max:100',
            'review_count'  => 'required|integer|min:0',
            'recency_data'  => 'nullable|array',
            'recency_data.0_6'   => 'nullable|integer',
            'recency_data.6_12'  => 'nullable|integer',
            'recency_data.12_18' => 'nullable|integer',
            'recency_data.18_24' => 'nullable|integer',
        ]);

        // Auto-normalise: if only raw is provided, normalise assuming 5-star max
        if (!isset($validated['rating_norm']) && isset($validated['rating_raw'])) {
            $validated['rating_norm'] = round(($validated['rating_raw'] / 5.0) * 100, 2);
        }

        $agg = ReviewAggregate::updateOrCreate(
            ['tool_id' => $tool->id, 'source_family' => $validated['source_family']],
            array_merge($validated, ['tool_id' => $tool->id, 'retrieved_at' => now()])
        );

        return back()->with('success', "Review aggregate for '{$validated['source_family']}' saved.");
    }

    // =========================================================================
    // CATEGORY TEMPLATES
    // =========================================================================

    public function templates()
    {
        $templates  = CategoryTemplate::with('category')->latest()->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('backend.admin.scoring.templates', compact('templates', 'categories'));
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'template_version' => 'required|string|max:50',
            'effective_date'   => 'required|date',
            'ai_depth_definition' => 'nullable|string',
        ]);

        $parseLines = fn(?string $text) => collect(explode("\n", (string)$text))
            ->map(fn($l) => trim($l))
            ->filter()
            ->values()
            ->toArray();

        $coreReqs  = $parseLines($request->input('core_requirements_text'));
        $advCaps   = $parseLines($request->input('advanced_capabilities_text'));
        $impInts   = $parseLines($request->input('important_integrations_text'));
        $segments  = $request->input('target_segments', []);

        if (empty($coreReqs)) {
            return back()->withErrors(['core_requirements_text' => 'At least one core requirement is required.']);
        }

        // Deactivate previous versions for this category
        CategoryTemplate::where('category_id', $request->category_id)->update(['is_active' => false]);

        $template = CategoryTemplate::create([
            'category_id'          => $request->category_id,
            'template_version'     => $request->template_version,
            'effective_date'       => $request->effective_date,
            'core_requirements'    => $coreReqs,
            'advanced_capabilities'=> $advCaps,
            'important_integrations'=> $impInts,
            'target_segments'      => $segments,
            'ai_depth_definition'  => $request->ai_depth_definition,
            'is_active'            => true,
        ]);

        ScoringAuditLog::record('CategoryTemplate', $template->id, 'create', null, $template->toArray());

        return back()->with('success', 'Category template v' . $template->template_version . ' created.');
    }

    // =========================================================================
    // METHODOLOGY VERSIONS
    // =========================================================================

    public function methodology()
    {
        $versions    = MethodologyVersion::latest('effective_date')->get();
        $current     = MethodologyVersion::current();
        $categories  = Category::orderBy('name')->get();

        return view('backend.admin.scoring.methodology', compact('versions', 'current', 'categories'));
    }

    public function storeMethodology(Request $request)
    {
        $validated = $request->validate([
            'version_name'               => 'required|string|unique:methodology_versions,version_name',
            'weights'                    => 'required|array',
            'weights.use_case_fit'       => 'required|numeric|min:0|max:1',
            'weights.ai_utility'         => 'required|numeric|min:0|max:1',
            'weights.usability'          => 'required|numeric|min:0|max:1',
            'weights.workflow_fit'       => 'required|numeric|min:0|max:1',
            'weights.value_pricing'      => 'required|numeric|min:0|max:1',
            'weights.trust_readiness'    => 'required|numeric|min:0|max:1',
            'weights.customer_evidence'  => 'required|numeric|min:0|max:1',
            'weights.product_health'     => 'required|numeric|min:0|max:1',
            'effective_date'             => 'required|date',
        ]);

        // Deactivate current
        MethodologyVersion::where('is_active', true)->update(['is_active' => false]);

        $version = MethodologyVersion::create([
            'version_name'      => $validated['version_name'],
            'weights'           => $validated['weights'],
            'global_parameters' => TAScoringEngine::DEFAULT_WEIGHTS, // carry forward defaults
            'effective_date'    => $validated['effective_date'],
            'is_active'         => true,
        ]);

        ScoringAuditLog::record('MethodologyVersion', $version->id, 'create', null, $version->toArray());

        return back()->with('success', "Methodology version '{$version->version_name}' created and activated.");
    }

    // =========================================================================
    // VENDOR CORRECTIONS
    // =========================================================================

    public function corrections(Request $request)
    {
        $query = VendorCorrection::with(['tool', 'submitter', 'reviewer'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $corrections = $query->paginate(20)->withQueryString();

        return view('backend.admin.scoring.corrections', compact('corrections'));
    }

    public function resolveCorrection(Request $request, VendorCorrection $correction)
    {
        $validated = $request->validate([
            'status'     => 'required|in:accepted,rejected',
            'resolution' => 'nullable|string|max:1000',
        ]);

        $before = $correction->only(['status', 'resolution']);

        $correction->update([
            'status'      => $validated['status'],
            'resolution'  => $validated['resolution'],
            'reviewer_id' => auth()->id(),
        ]);

        ScoringAuditLog::record('VendorCorrection', $correction->id, 'resolve', $before, $correction->fresh()->toArray());

        // If accepted, trigger re-score
        if ($validated['status'] === 'accepted') {
            $categories = $correction->tool->categories;
            foreach ($categories as $cat) {
                $this->scoringEngine->score($correction->tool, $cat->id, false, true);
            }
            return back()->with('success', 'Correction accepted. Score recalculated automatically.');
        }

        return back()->with('success', 'Correction rejected. Score unchanged.');
    }

    // =========================================================================
    // AUDIT LOG
    // =========================================================================

    public function auditLog(Request $request)
    {
        $query = ScoringAuditLog::with('actor')->latest('timestamp');

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(30)->withQueryString();

        return view('backend.admin.scoring.audit-log', compact('logs'));
    }

    // =========================================================================
    // RANKING
    // =========================================================================

    public function publishRanks(Category $category)
    {
        $result = $this->rankingService->publishCategoryRanks($category->id);

        return back()->with('success', "Published ranks for {$result['ranked']} tools in \"{$category->name}\".");
    }

    public function leaderboard(Category $category)
    {
        $runs = $this->rankingService->getCategoryLeaderboard($category->id);

        return view('backend.admin.scoring.leaderboard', compact('category', 'runs'));
    }
}
