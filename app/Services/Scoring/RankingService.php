<?php

namespace App\Services\Scoring;

use App\Models\Category;
use App\Models\RankSnapshot;
use App\Models\ScoreRun;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Ranking Service — computes and persists category rank snapshots.
 *
 * Spec rules:
 *  - Adding/removing competitors does NOT change another product's TA Score;
 *    it can change only the category rank.
 *  - Displayed TA Score is absolute (not normalised against competitors).
 *  - Rank algorithm: sort ranked-eligible products by category-specific
 *    public_score descending.
 *  - Tie: scores within 0.1 points after rounding are tied.
 *  - Tie-break order (only when exact order required):
 *    1. Higher confidence_score
 *    2. Higher use_case_fit dimension score
 *    3. Higher customer_evidence dimension score
 *    4. Equal rank if still tied.
 *  - Paid plan, sponsorship, affiliate, homepage placement are FORBIDDEN inputs.
 */
class RankingService
{
    /**
     * Publish rank snapshots for an entire category using the latest
     * published ScoreRun per tool.
     */
    public function publishCategoryRanks(int $categoryId): array
    {
        $category = Category::findOrFail($categoryId);

        // Collect the latest published ScoreRun for each tool in this category
        $latestRuns = ScoreRun::where('category_id', $categoryId)
            ->where('is_published', true)
            ->whereIn('status', ['ranked'])
            ->with(['breakdowns'])
            ->get()
            ->sortByDesc(fn($r) => $r->run_at)
            ->unique('tool_id')  // one per tool (latest)
            ->values();

        if ($latestRuns->isEmpty()) {
            return ['ranked' => 0, 'snapshots' => []];
        }

        // Sort by public_score desc, then tie-break
        $sorted = $this->sortRuns($latestRuns);

        $snapshotDate  = Carbon::today()->startOfDay();
        $eligibleCount = $sorted->count();
        $snapshots     = [];

        DB::transaction(function () use ($sorted, $categoryId, $snapshotDate, $eligibleCount, &$snapshots) {
            $rank = 1;

            foreach ($sorted as $i => $run) {
                // Determine if tied with previous
                if ($i > 0) {
                    $prev = $sorted[$i - 1];
                    if ($this->isTied($run, $prev)) {
                        // Use same rank as previous
                        $rank = $snapshots[count($snapshots) - 1]['rank'];
                    }
                }

                $snapshot = RankSnapshot::updateOrCreate(
                    [
                        'category_id'   => $categoryId,
                        'tool_id'       => $run->tool_id,
                        'snapshot_date' => $snapshotDate,
                    ],
                    [
                        'score_run_id'  => $run->id,
                        'rank'          => $rank,
                        'eligible_count'=> $eligibleCount,
                    ]
                );

                $snapshots[] = ['rank' => $rank, 'tool_id' => $run->tool_id, 'public_score' => $run->public_score];

                // Only increment rank if not tied
                if ($i + 1 < $sorted->count() && !$this->isTied($run, $sorted[$i + 1])) {
                    $rank++;
                } elseif ($i + 1 < $sorted->count() && $this->isTied($run, $sorted[$i + 1])) {
                    // keep same rank for next item
                } else {
                    $rank++;
                }
            }
        });

        return ['ranked' => $eligibleCount, 'snapshots' => $snapshots];
    }

    /**
     * Get current rank for a tool in a category.
     */
    public function getCurrentRank(int $toolId, int $categoryId): ?array
    {
        $snapshot = RankSnapshot::where('tool_id', $toolId)
            ->where('category_id', $categoryId)
            ->latest('snapshot_date')
            ->first();

        if (!$snapshot) {
            return null;
        }

        return [
            'rank'           => $snapshot->rank,
            'eligible_count' => $snapshot->eligible_count,
            'snapshot_date'  => $snapshot->snapshot_date,
        ];
    }

    /**
     * Rank the category leaderboard (for display — does not persist).
     */
    public function getCategoryLeaderboard(int $categoryId): Collection
    {
        $latestRuns = ScoreRun::where('category_id', $categoryId)
            ->where('is_published', true)
            ->whereIn('status', ['ranked', 'provisional'])
            ->with(['tool', 'breakdowns'])
            ->get()
            ->sortByDesc(fn($r) => $r->run_at)
            ->unique('tool_id')
            ->values();

        return $this->sortRuns($latestRuns);
    }

    // =========================================================================
    // SORT HELPERS
    // =========================================================================

    /**
     * Sort ScoreRun collection per spec rank algorithm.
     */
    private function sortRuns(Collection $runs): Collection
    {
        return $runs->sort(function (ScoreRun $a, ScoreRun $b) {
            // 1. Public score descending
            if ($a->public_score !== $b->public_score) {
                return $b->public_score <=> $a->public_score;
            }
            // 2. Confidence score descending
            if ($a->confidence_score !== $b->confidence_score) {
                return $b->confidence_score <=> $a->confidence_score;
            }
            // 3. Use-Case Fit dimension score descending
            $aUCF = $this->getDimensionScore($a, 'use_case_fit');
            $bUCF = $this->getDimensionScore($b, 'use_case_fit');
            if ($aUCF !== $bUCF) {
                return $bUCF <=> $aUCF;
            }
            // 4. Customer Evidence score descending
            $aCE = $this->getDimensionScore($a, 'customer_evidence');
            $bCE = $this->getDimensionScore($b, 'customer_evidence');
            return $bCE <=> $aCE;
        })->values();
    }

    private function getDimensionScore(ScoreRun $run, string $dimensionKey): float
    {
        return $run->breakdowns
            ->where('dimension_key', $dimensionKey)
            ->sum('points_awarded');
    }

    /**
     * Two scores are tied when within 0.1 after rounding.
     */
    private function isTied(ScoreRun $a, ScoreRun $b): bool
    {
        return abs($a->public_score - $b->public_score) <= 0.1;
    }
}
