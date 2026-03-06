@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Sponsorships')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Monetization /</span> Sponsorships</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">Tool Sponsorships</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="sponsorships-table">
                    <thead>
                        <tr>
                            <th>Tool</th>
                            <th>Vendor</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Period</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($sponsorships as $sponsorship)
                            <tr>
                                <td><strong>{{ $sponsorship->tool->name ?? 'Deleted Tool' }}</strong></td>
                                <td>{{ $sponsorship->vendor->company_name ?? 'N/A' }}</td>
                                <td><span
                                        class="badge bg-label-info">{{ ucfirst($sponsorship->placement_type ?? 'Standard') }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ $sponsorship->status == 'active' ? 'success' : ($sponsorship->status == 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($sponsorship->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($sponsorship->starts_at && $sponsorship->ends_at)
                                        {{ $sponsorship->starts_at->format('M d') }} -
                                        {{ $sponsorship->ends_at->format('M d, Y') }}
                                    @else
                                        Not set
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sponsorships.show', $sponsorship) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-edit-alt me-1"></i> Manage
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
            if (document.getElementById('sponsorships-table')) {
                new DataTable('#sponsorships-table', {
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        search: "",
                        searchPlaceholder: "Search Sponsorships...",
                        lengthMenu: "_MENU_"
                    },
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
