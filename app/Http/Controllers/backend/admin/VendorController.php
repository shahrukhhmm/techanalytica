<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->latest()->get();
        return view('backend.admin.content.vendors.index', compact('vendors'));
    }

    public function create()
    {
        $users = User::doesntHave('vendor')->orderBy('name')->get();
        return view('backend.admin.content.vendors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:vendors,user_id',
            'company_name' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_size' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
            'billing_address' => 'nullable|string',
        ]);

        Vendor::create($validated);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['user', 'tools', 'claims', 'sponsorships', 'billingTransactions']);
        return view('backend.admin.content.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $users = User::whereDoesntHave('vendor', function($query) use ($vendor) {
            $query->where('id', '!=', $vendor->id);
        })->orderBy('name')->get();
        
        return view('backend.admin.content.vendors.edit', compact('vendor', 'users'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:vendors,user_id,' . $vendor->id,
            'company_name' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_size' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
            'billing_address' => 'nullable|string',
        ]);

        $vendor->update($validated);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
