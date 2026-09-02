<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\LeadReceived;
use App\Models\AnalyticsEvent;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Claim;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\Review;
use App\Models\Submission;
use App\Models\Tool;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $aiType = $request->input('ai_type');

        $query = Tool::with(['categories', 'tier', 'reviews'])
            ->where('status', 'published');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('ai_type', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        if ($aiType) {
            $query->where('ai_type', $aiType);
        }

        $featuredTools = (clone $query)->where('is_featured', true)->latest()->take(6)->get();
        $tools = $query->take(6)->get();
        $categories = Category::withCount('tools')->get();
        $latestBlogs = Blog::with('author')->where('status', 'published')->latest()->take(3)->get();
        $unclaimedTools = Tool::where('is_claimed', false)->where('status', 'published')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.home.index', compact(
            'tools',
            'featuredTools',
            'categories',
            'latestBlogs',
            'unclaimedTools',
            'navIndustries',
            'search',
            'categoryId',
            'aiType'
        ));
    }

    public function tools(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $aiType = $request->input('ai_type');
        $pricing = $request->input('pricing');
        $minRating = $request->input('min_rating');

        $query = Tool::with(['categories', 'tier', 'reviews'])
            ->where('status', 'published');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('ai_type', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        if ($aiType) {
            $query->where('ai_type', $aiType);
        }

        if ($pricing) {
            if ($pricing === 'free') {
                $query->where(function($q) {
                    $q->where('pricing_text', 'like', '%free%')
                      ->orWhereHas('tier', fn($t) => $t->where('name', 'Free'));
                });
            } elseif ($pricing === 'paid') {
                $query->where(function($q) {
                    $q->where('pricing_text', 'like', '%$%')
                      ->orWhereHas('tier', fn($t) => $t->where('monthly_price', '>', 0));
                });
            }
        }

        $tools = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::withCount('tools')->get();
        $unclaimedTools = Tool::where('is_claimed', false)->where('status', 'published')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.tools.index', compact(
            'tools',
            'categories',
            'unclaimedTools',
            'navIndustries',
            'search',
            'categoryId',
            'aiType',
            'pricing',
            'minRating'
        ));
    }

    public function toolDetail($slug)
    {
        $tool = Tool::with(['categories', 'tier', 'reviews.user', 'media', 'vendor'])
            ->where('slug', $slug)
            ->first();

        if (!$tool) {
            $tool = Tool::with(['categories', 'tier', 'reviews.user', 'media', 'vendor'])->firstOrFail();
        }

        // Automatically log anonymous view event
        try {
            AnalyticsEvent::create([
                'tool_id' => $tool->id,
                'vendor_id' => $tool->vendor_id,
                'event_type' => 'view',
                'timestamp' => now(),
                'referrer' => request()->header('referer'),
                'session_id' => session()->getId(),
                'device' => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // Non-blocking telemetry
        }

        $relatedTools = Tool::whereHas('categories', function ($q) use ($tool) {
            $q->whereIn('categories.id', $tool->categories->pluck('id'));
        })->where('id', '!=', $tool->id)->where('status', 'published')->take(4)->get();

        $unclaimedTools = Tool::where('is_claimed', false)->where('status', 'published')->get();
        $categories = Category::withCount('tools')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.vendors.show', compact('tool', 'relatedTools', 'unclaimedTools', 'categories', 'navIndustries'));
    }

    public function compare(Request $request)
    {
        $allTools = Tool::where('status', 'published')->orderBy('name')->get();

        $tool1Slug = $request->input('tool1');
        $tool2Slug = $request->input('tool2');

        $tool1 = $tool1Slug ? Tool::with(['categories', 'tier', 'reviews', 'media'])->where('slug', $tool1Slug)->first() : $allTools->first();
        $tool2 = $tool2Slug ? Tool::with(['categories', 'tier', 'reviews', 'media'])->where('slug', $tool2Slug)->first() : ($allTools->skip(1)->first() ?? $allTools->first());

        $unclaimedTools = Tool::where('is_claimed', false)->where('status', 'published')->get();
        $categories = Category::withCount('tools')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.compare.index', compact('allTools', 'tool1', 'tool2', 'unclaimedTools', 'categories', 'navIndustries'));
    }

    public function exportComparison(Request $request, $format = 'pdf')
    {
        $tool1Slug = $request->input('tool1');
        $tool2Slug = $request->input('tool2');

        $tool1 = Tool::with(['categories', 'tier', 'reviews'])->where('slug', $tool1Slug)->firstOrFail();
        $tool2 = Tool::with(['categories', 'tier', 'reviews'])->where('slug', $tool2Slug)->firstOrFail();

        if ($format === 'csv') {
            $fileName = "comparison_{$tool1->slug}_vs_{$tool2->slug}.csv";
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
            ];

            $callback = function() use ($tool1, $tool2) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Metric / Specification', $tool1->name, $tool2->name]);
                fputcsv($file, ['AI Type', $tool1->ai_type ?? 'AI Tool', $tool2->ai_type ?? 'AI Tool']);
                fputcsv($file, ['TechScore Rating', $tool1->score . '/100', $tool2->score . '/100']);
                fputcsv($file, ['User Community Rating', number_format($tool1->reviews->avg('rating') ?: 4.5, 1) . ' Stars', number_format($tool2->reviews->avg('rating') ?: 4.0, 1) . ' Stars']);
                fputcsv($file, ['Reviews Count', $tool1->reviews->count(), $tool2->reviews->count()]);
                fputcsv($file, ['Pricing Model', $tool1->pricing_text ?? ($tool1->tier->name ?? 'Freemium'), $tool2->pricing_text ?? ($tool2->tier->name ?? 'Freemium')]);
                fputcsv($file, ['Categories', $tool1->categories->pluck('name')->join(', '), $tool2->categories->pluck('name')->join(', ')]);
                fputcsv($file, ['Website URL', $tool1->website_url ?? 'N/A', $tool2->website_url ?? 'N/A']);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // PDF Export
        $pdf = Pdf::loadView('frontend.pages.compare.pdf', compact('tool1', 'tool2'));
        return $pdf->download("comparison_{$tool1->slug}_vs_{$tool2->slug}.pdf");
    }

    public function leaderboard(Request $request)
    {
        $categoryId = $request->input('category_id');
        $aiType = $request->input('ai_type');

        $query = Tool::with(['categories', 'tier', 'reviews', 'analyticsEvents'])
            ->where('status', 'published');

        if ($categoryId) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
        }

        if ($aiType) {
            $query->where('ai_type', $aiType);
        }

        $allTools = $query->get();

        // Sort by computed Product Score descending
        $rankedTools = $allTools->sortByDesc(function ($tool) {
            return $tool->score;
        })->values();

        $categories = Category::withCount('tools')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.leaderboard.index', compact('rankedTools', 'categories', 'navIndustries', 'categoryId', 'aiType'));
    }

    public function submitLead(Request $request, $slug)
    {
        $tool = Tool::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'intent_type' => 'required|in:demo,pricing,contact,custom_quote',
            'message' => 'nullable|string|max:1000',
        ]);

        $lead = Lead::create([
            'tool_id' => $tool->id,
            'vendor_id' => $tool->vendor_id,
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company_name' => $validated['company_name'] ?? null,
            'company_size' => $validated['company_size'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'intent_type' => $validated['intent_type'],
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        // Send alert email to Vendor
        if ($tool->vendor && $tool->vendor->billing_email) {
            try {
                Mail::to($tool->vendor->billing_email)->send(new LeadReceived($lead, false));
            } catch (\Exception $e) {}
        }

        // Send alert to Admin
        try {
            Mail::to('admin@techanalytica.com')->send(new LeadReceived($lead, true));
        } catch (\Exception $e) {}

        return redirect()->back()->with('success', 'Your inquiry has been sent directly to the vendor team! They will reach out shortly.');
    }

    public function toggleFavorite(Request $request, $toolId)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please log in to save favorites.'], 401);
        }

        $user = auth()->user();
        $isFavorited = $user->favorites()->where('tool_id', $toolId)->exists();

        if ($isFavorited) {
            $user->favorites()->detach($toolId);
            return response()->json(['status' => 'removed', 'message' => 'Tool removed from favorites.']);
        } else {
            $user->favorites()->attach($toolId);
            return response()->json(['status' => 'added', 'message' => 'Tool added to your favorites!']);
        }
    }

    public function submitClaim(Request $request)
    {
        $validated = $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'full_name' => 'required|string|max:255',
            'work_email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'verification_info' => 'nullable|string',
        ]);

        Claim::create([
            'tool_id' => $validated['tool_id'],
            'full_name' => $validated['full_name'],
            'work_email' => $validated['work_email'],
            'company_name' => $validated['company_name'] ?? null,
            'company_website' => $validated['company_website'] ?? null,
            'verification_info' => $validated['verification_info'] ?? null,
            'status' => 'pending',
            'reason' => 'Public tool ownership claim request submitted via frontend modal.',
        ]);

        return redirect()->back()->with('success', 'Your claim request for the selected AI tool has been submitted successfully! Our verification team will review and provision your vendor credentials.');
    }

    public function submitTool(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'required|url|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:500',
            'pricing_text' => 'nullable|string|max:255',
            'contact_email' => 'required|email|max:255',
        ]);

        Submission::create([
            'tool_name' => $validated['name'],
            'fields' => $validated,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your AI tool submission has been received! Our editorial team will review and list it shorty.');
    }

    public function submitReview(Request $request, $slug)
    {
        $tool = Tool::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        Review::create([
            'tool_id' => $tool->id,
            'user_id' => auth()->id(),
            'user_name' => $validated['reviewer_name'],
            'user_email' => $validated['reviewer_email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified' => auth()->check(),
            'verification_type' => auth()->check() ? 'authenticated_user' : 'guest_email',
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted for moderation and will appear upon verification.');
    }

    public function blogs(Request $request)
    {
        $categoryId = $request->input('category_id');

        $query = Blog::with(['author', 'category', 'tags'])->where('status', 'published');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $blogs = $query->latest()->paginate(9)->withQueryString();
        $featuredBlog = Blog::with(['author', 'category'])->where('status', 'published')->latest()->first();
        $unclaimedTools = Tool::where('is_claimed', false)->where('status', 'published')->get();
        $categories = Category::withCount('tools')->get();
        $blogCategories = BlogCategory::withCount('blogs')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.blogs.index', compact('blogs', 'featuredBlog', 'blogCategories', 'unclaimedTools', 'categories', 'navIndustries', 'categoryId'));
    }

    public function blogDetail($slug = null)
    {
        $query = Blog::with(['author', 'category', 'tags'])->where('status', 'published');
        $blog = null;
        if ($slug) {
            $blog = (clone $query)->where('slug', $slug)->first();
        }
        if (!$blog) {
            $blog = $query->latest()->first() ?? Blog::latest()->firstOrFail();
        }

        $recentBlogs = Blog::where('id', '!=', $blog->id)->where('status', 'published')->latest()->take(4)->get();
        $unclaimedTools = Tool::where('is_claimed', false)->where('status', 'published')->get();
        $categories = Category::withCount('tools')->get();
        $navIndustries = Industry::where('approved', true)->withCount('tools')->take(6)->get();

        return view('frontend.pages.blogs.show', compact('blog', 'recentBlogs', 'unclaimedTools', 'categories', 'navIndustries'));
    }

    public function vendorDetail($slug)
    {
        return $this->toolDetail($slug);
    }
}
