<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::latest()->get();
        
        return view('backend.admin.content.newsletters.index', compact('newsletters'));
    }

    public function subscribers()
    {
        $subscribers = Subscriber::latest()->get();
        
        return view('backend.admin.content.newsletters.subscribers', compact('subscribers'));
    }

    public function create()
    {
        return view('backend.admin.content.newsletters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,sent',
        ]);

        if ($validated['status'] === 'sent') {
            $validated['sent_at'] = now();
        }

        Newsletter::create($validated);

        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter created successfully.');
    }

    public function show(Newsletter $newsletter)
    {
        return view('backend.admin.content.newsletters.show', compact('newsletter'));
    }

    public function edit(Newsletter $newsletter)
    {
        return view('backend.admin.content.newsletters.edit', compact('newsletter'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,sent',
        ]);

        if ($validated['status'] === 'sent' && !$newsletter->sent_at) {
            $validated['sent_at'] = now();
        }

        $newsletter->update($validated);

        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter updated successfully.');
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter deleted successfully.');
    }

    public function send(Newsletter $newsletter)
    {
        if ($newsletter->status === 'sent') {
            return redirect()->back()->with('error', 'This newsletter has already been sent.');
        }

        $subscriberCount = Subscriber::where('status', 'active')->count();
        
        $newsletter->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.newsletters.index')->with('success', "Newsletter sent successfully to {$subscriberCount} subscribers.");
    }

    public function destroySubscriber(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->back()->with('success', 'Subscriber removed successfully.');
    }
}
