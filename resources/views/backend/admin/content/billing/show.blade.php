@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Transaction Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Billing /</span> Details</h4>

        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <h5 class="card-header">Transaction #{{ $transaction->transaction_id ?? $transaction->id }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Vendor</label>
                                <p>{{ $transaction->vendor->company_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Related Tool</label>
                                <p>{{ $transaction->tool->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Amount</label>
                                <p class="h4 text-primary">${{ number_format($transaction->amount, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Payment Method</label>
                                <p>{{ ucfirst($transaction->payment_method ?? 'Stripe') }}</p>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Metadata / Notes</label>
                                <pre class="bg-light p-2 rounded">{{ json_encode($transaction->metadata ?? [], JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <h5 class="card-header">Transaction Control</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.billing.update-status', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="status" class="form-label">Update Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ in_array($transaction->status, ['paid', 'completed']) ? 'selected' : '' }}>Paid / Completed</option>
                                    <option value="failed" {{ $transaction->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $transaction->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
