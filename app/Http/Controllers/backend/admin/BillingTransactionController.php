<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\BillingTransaction;
use Illuminate\Http\Request;

class BillingTransactionController extends Controller
{
    public function index()
    {
        $transactions = BillingTransaction::with(['vendor', 'tool'])->latest()->get();
        return view('backend.admin.content.billing.index', compact('transactions'));
    }

    public function show(BillingTransaction $transaction)
    {
        return view('backend.admin.content.billing.show', compact('transaction'));
    }

    public function updateStatus(Request $request, BillingTransaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,completed,failed,refunded',
        ]);

        if ($validated['status'] === 'completed') {
            $validated['status'] = 'paid';
        }

        $transaction->update($validated);

        return back()->with('success', 'Transaction status updated.');
    }
}
