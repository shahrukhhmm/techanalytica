@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Product Submissions')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Management /</span> Submissions</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">Vendor Submissions</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="submissions-table">
                    <thead>
                        <tr>
                            <th>Tool Name</th>
                            <th>Vendor</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($submissions as $submission)
                            <tr>
                                <td><strong>{{ $submission->tool_name }}</strong></td>
                                <td>{{ $submission->vendor->company_name ?? 'N/A' }}</td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ $submission->status == 'approved' ? 'success' : ($submission->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td>{{ $submission->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.submissions.show', $submission) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show me-1"></i> Review
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
            if (document.getElementById('submissions-table')) {
                new DataTable('#submissions-table', {
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        search: "",
                        searchPlaceholder: "Search Submissions...",
                        lengthMenu: "_MENU_"
                    },
                    order: [
                        [3, "desc"]
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
