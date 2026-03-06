<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index()
    {
        $sponsorships = Sponsorship::with(['tool', 'vendor', 'category'])->latest()->get();
        return view('backend.admin.content.sponsorships.index', compact('sponsorships'));
    }

    public function show(Sponsorship $sponsorship)
    {
        return view('backend.admin.content.sponsorships.show', compact('sponsorship'));
    }

    public function updateStatus(Request $request, Sponsorship $sponsorship)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $sponsorship->update($validated);

        return back()->with('success', 'Sponsorship status updated successfully.');
    }

    public function destroy(Sponsorship $sponsorship)
    {
        $sponsorship->delete();
        return redirect()->route('admin.sponsorships.index')->with('success', 'Sponsorship deleted.');
    }
}
