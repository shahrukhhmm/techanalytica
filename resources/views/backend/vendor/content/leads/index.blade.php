@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Buyer Inquiries & Leads')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Buyer Inquiries & Leads</h4>
            <a href="{{ route('vendor.leads.export') }}" class="btn btn-outline-success">
                <i class="bx bx-download me-1"></i> Export Leads (CSV)
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Prospect</th>
                                <th>Company & Size</th>
                                <th>Inquiry Type</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr>
                                    <td><strong>{{ $lead->tool->name }}</strong></td>
                                    <td>
                                        <strong>{{ $lead->name }}</strong><br>
                                        <a href="mailto:{{ $lead->email }}" class="text-primary small">{{ $lead->email }}</a>
                                        @if($lead->phone)
                                            <br><small class="text-muted">{{ $lead->phone }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $lead->company_name ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ $lead->company_size ? $lead->company_size.' members' : '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">{{ ucfirst($lead->intent_type) }}</span>
                                    </td>
                                    <td>
                                        <div style="max-width: 220px; font-size: 13px;" title="{{ $lead->message }}">
                                            {{ $lead->message ? Str::limit($lead->message, 80) : 'No custom message.' }}
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('vendor.leads.update-status', $lead->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto;">
                                                <option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>New</option>
                                                <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                <option value="qualified" {{ $lead->status == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                                <option value="closed" {{ $lead->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $lead->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No buyer inquiries received yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $leads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
