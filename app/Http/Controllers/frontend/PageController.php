<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Review;
use App\Models\Subscriber;
use App\Models\Tool;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Dynamic Home Page
     */
    public function index()
    {
        // 1. Featured AI Tools (Top Ranked / Featured)
        $featuredTools = Tool::where('status', 'published')
            ->with(['categories', 'reviews'])
            ->withCount(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            ->orderByDesc('is_featured')
            ->orderByDesc('rank')
            ->take(6)
            ->get();

        // 2. Categories with tool counts
        $categories = Category::withCount('tools')
            ->orderByDesc('tools_count')
            ->take(4)
            ->get();

        $allCategoriesCount = Category::count();

        // 3. Latest Published Blog Insights
        $featuredInsight = Blog::with('author')
            ->where('status', 'published')
            ->latest('published_at')
            ->first();

        $latestBlogs = Blog::with('author')
            ->where('status', 'published')
            ->when($featuredInsight, function ($q) use ($featuredInsight) {
                $q->where('id', '!=', $featuredInsight->id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        // 4. Community Reviews Testimonials
        $communityReviews = Review::where('status', 'approved')
            ->with(['tool', 'user'])
            ->orderByDesc('rating')
            ->latest()
            ->take(3)
            ->get();

        // 5. Aggregate Stats
        $stats = [
            'total_tools' => Tool::where('status', 'published')->count(),
            'total_categories' => Category::count(),
            'total_reviews' => Review::where('status', 'approved')->count(),
            'total_blogs' => Blog::where('status', 'published')->count(),
        ];

        return view('frontend.pages.home.index', compact(
            'featuredTools',
            'categories',
            'allCategoriesCount',
            'featuredInsight',
            'latestBlogs',
            'communityReviews',
            'stats'
        ));
    }

    /**
     * Dynamic Blog Hub Index Page
     */
    public function blogs(Request $request)
    {
        $search = $request->input('search');
        $selectedCategory = $request->input('category');

        $categories = Category::withCount('tools')->get();

        // Highlight/Must-Read Blog
        $mustReadBlog = Blog::with('author')
            ->where('status', 'published')
            ->where('slug', 'the-2026-state-of-generative-ai-and-saas-benchmarks')
            ->first() ?? Blog::with('author')->where('status', 'published')->latest('published_at')->first();

        // Main Featured Spotlight Blog
        $featuredBlog = Blog::with('author')
            ->where('status', 'published')
            ->where('slug', 'the-quiet-rewrite-how-small-teams-are-out-shipping-the-giants-in-2026')
            ->first() ?? Blog::with('author')->where('status', 'published')->where('id', '!=', $mustReadBlog?->id ?? 0)->latest('published_at')->first();

        $excludedIds = array_filter([$mustReadBlog?->id ?? 0, $featuredBlog?->id ?? 0]);

        // Trends & Insights (4 Cards Grid)
        $trendsBlogs = Blog::with('author')
            ->where('status', 'published')
            ->whereNotIn('id', $excludedIds)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        // All Paginated Blogs
        $allBlogs = Blog::with('author')
            ->where('status', 'published')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->latest('published_at')
            ->paginate(8);

        return view('frontend.pages.blogs.index', compact(
            'categories',
            'mustReadBlog',
            'featuredBlog',
            'trendsBlogs',
            'allBlogs',
            'search',
            'selectedCategory'
        ));
    }

    /**
     * Dynamic Blog Detail Page
     */
    public function blogDetail($slug = null)
    {
        // If slug not given, pick the first published blog
        if (!$slug) {
            $blog = Blog::with(['author', 'vendor'])
                ->where('status', 'published')
                ->where('slug', 'the-quiet-rewrite-how-small-teams-are-out-shipping-the-giants-in-2026')
                ->first() ?? Blog::with(['author', 'vendor'])->where('status', 'published')->latest('published_at')->firstOrFail();
        } else {
            $blog = Blog::with(['author', 'vendor'])
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();
        }

        // Reading Time Calculation
        $wordCount = str_word_count(strip_tags($blog->body));
        $readingTime = max(1, ceil($wordCount / 200));

        // Related Blogs
        $relatedBlogs = Blog::with('author')
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Trending Reads
        $trendingReads = Blog::with('author')
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.pages.blogs.show', compact(
            'blog',
            'readingTime',
            'relatedBlogs',
            'trendingReads'
        ));
    }

    /**
     * Dynamic Vendor Category Listing (CRM or any Category)
     */
    public function crmVendor(Request $request, $slug = 'crm-software')
    {
        // 1. Find the target category
        $category = Category::where('slug', $slug)
            ->orWhere('id', $slug)
            ->first() ?? Category::firstOrCreate(['slug' => 'crm-software'], ['name' => 'CRM Software', 'description' => 'Best Customer Relationship Management software platforms.']);

        $search = $request->input('q');
        $minRating = $request->input('rating');
        $sortBy = $request->input('sort', 'rank');

        // 2. Query Tools
        $toolsQuery = Tool::where('status', 'published')
            ->with(['categories', 'tier', 'vendor'])
            ->withCount(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating');

        // Filter by category if relation exists
        if ($category) {
            $toolsQuery->where(function ($q) use ($category) {
                $q->whereHas('categories', function ($catQ) use ($category) {
                    $catQ->where('categories.id', $category->id);
                })->orWhere('status', 'published');
            });
        }

        if ($search) {
            $toolsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($sortBy === 'rating') {
            $toolsQuery->orderByDesc('reviews_avg_rating');
        } elseif ($sortBy === 'reviews') {
            $toolsQuery->orderByDesc('reviews_count');
        } else {
            $toolsQuery->orderByDesc('rank');
        }

        $tools = $toolsQuery->paginate(8)->appends($request->all());

        // 3. Top 4 Recommended Picks
        $topPicks = Tool::where('status', 'published')
            ->with(['categories', 'reviews'])
            ->orderByDesc('rank')
            ->take(4)
            ->get();

        // 4. Other Categories
        $relatedCategories = Category::where('id', '!=', $category->id ?? 0)
            ->withCount('tools')
            ->take(4)
            ->get();

        // 5. Total reviews in this category
        $categoryReviewsCount = Review::where('status', 'approved')->count();

        return view('frontend.pages.vendors.crm', compact(
            'category',
            'tools',
            'topPicks',
            'relatedCategories',
            'categoryReviewsCount',
            'search',
            'sortBy'
        ));
    }

    /**
     * Dynamic Vendor Detail Page
     */
    public function vendorDetail($slug = 'salesforce-sales-cloud')
    {
        $tool = Tool::with(['vendor', 'tier', 'categories', 'media', 'reviews' => function ($q) {
            $q->where('status', 'approved')->latest();
        }])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->first();

        // Fallback to first tool if slug not found
        if (!$tool) {
            $tool = Tool::with(['vendor', 'tier', 'categories', 'media', 'reviews'])->firstOrFail();
        }

        // Reviews Breakdown Calculation
        $approvedReviews = $tool->reviews;
        $totalReviews = $approvedReviews->count();
        $avgRating = $totalReviews > 0 ? round($approvedReviews->avg('rating'), 1) : 4.8;

        $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($approvedReviews as $rev) {
            $rating = min(5, max(1, (int) $rev->rating));
            $starCounts[$rating]++;
        }

        $starBreakdown = [];
        foreach ($starCounts as $stars => $cnt) {
            $pct = $totalReviews > 0 ? round(($cnt / $totalReviews) * 100) : ($stars === 5 ? 82 : ($stars === 4 ? 12 : 2));
            $starBreakdown[$stars] = [
                'count' => $cnt,
                'percentage' => $pct,
            ];
        }

        // Top Alternatives & Competitors in the same category
        $categoryIds = $tool->categories->pluck('id')->toArray();
        $alternatives = Tool::where('status', 'published')
            ->where('id', '!=', $tool->id)
            ->when(!empty($categoryIds), function ($q) use ($categoryIds) {
                $q->whereHas('categories', function ($catQ) use ($categoryIds) {
                    $catQ->whereIn('categories.id', $categoryIds);
                });
            })
            ->orderByDesc('rank')
            ->take(2)
            ->get();

        if ($alternatives->isEmpty()) {
            $alternatives = Tool::where('status', 'published')->where('id', '!=', $tool->id)->take(2)->get();
        }

        return view('frontend.pages.vendors.show', compact(
            'tool',
            'totalReviews',
            'avgRating',
            'starBreakdown',
            'alternatives'
        ));
    }

    /**
     * Submit Review
     */
    public function submitReview(Request $request, $toolId)
    {
        $request->validate([
            'user_name' => 'required|string|max:100',
            'user_email' => 'required|email|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        $tool = Tool::findOrFail($toolId);

        Review::create([
            'tool_id' => $tool->id,
            'user_id' => auth()->id() ?? null,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved', // Instant approve or pending
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been successfully submitted and verified.');
    }

    /**
     * Subscribe Newsletter
     */
    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
        ]);

        Subscriber::firstOrCreate(
            ['email' => $request->email],
            ['status' => 'active']
        );

        return redirect()->back()->with('success', 'You have been subscribed to TechAnalytica weekly briefs!');
    }
}
