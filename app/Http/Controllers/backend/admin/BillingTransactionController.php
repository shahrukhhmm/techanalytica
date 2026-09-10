<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\BillingTransaction;
use Illuminate\Http\Request;

class BillingTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = BillingTransaction::with(['vendor', 'tool'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('vendor', function ($vq) use ($search) {
                      $vq->where('company_name', 'like', "%{$search}%");
                  })->orWhereHas('tool', function ($tq) use ($search) {
                      $tq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(15)->withQueryString();
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
