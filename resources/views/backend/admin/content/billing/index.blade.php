@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Billing Logs')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Monetization /</span> Billing Logs</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">Transaction History</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="billing-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td><strong>#{{ $transaction->transaction_id ?? $transaction->id }}</strong></td>
                                <td>{{ $transaction->vendor->company_name ?? 'N/A' }}</td>
                                <td>${{ number_format($transaction->amount, 2) }}</td>
                                <td><span class="badge bg-label-info">{{ ucfirst($transaction->type) }}</span></td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ in_array($transaction->status, ['completed', 'paid']) ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.billing.show', $transaction) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show me-1"></i> Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin: 1rem 1.5rem;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 1.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('billing-table')) {
                new DataTable('#billing-table', {
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        search: "",
                        searchPlaceholder: "Search Transactions...",
                        lengthMenu: "_MENU_"
                    },
                    order: [
                        [5, "desc"]
                    ],
                    pageLength: 10,
                    responsive: true
                });

                document.querySelectorAll('.dataTables_filter input').forEach(el => el.classList.add(
                    'form-control'));
                document.querySelectorAll('.dataTables_length select').forEach(el => el.classList.add(
                    'form-select'));
            }
        });
    </script>
@endsection
