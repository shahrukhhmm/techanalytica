@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Newsletter Details - ' . $newsletter->subject)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Newsletters /</span> Details</h4>
            <div class="d-flex gap-2">
                @if ($newsletter->status == 'draft')
                    <a href="{{ route('admin.newsletters.edit', $newsletter) }}" class="btn btn-primary">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                @endif
                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom bg-light">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $newsletter->subject }}</h3>
                        <div class="text-muted small">
                            Created on {{ $newsletter->created_at->format('M d, Y') }}
                            @if ($newsletter->sent_at)
                                &bull; Sent on {{ $newsletter->sent_at->format('M d, Y H:i') }}
                            @endif
                        </div>
                    </div>
                    <span
                        class="badge @if ($newsletter->status == 'sent') bg-label-success @else bg-label-warning @endif fs-6 px-3 py-2">
                        {{ ucfirst($newsletter->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body p-5">
                <div class="newsletter-content border rounded p-4 bg-white" style="min-height: 400px; line-height: 1.6;">
                    {!! nl2br(e($newsletter->content)) !!}
                </div>
            </div>
            <div class="card-footer bg-light border-top">
                <div class="text-muted small">
                    <i class="bx bx-info-circle me-1"></i> This newsletter content is managed by the system administrators.
                </div>
            </div>
        </div>
    </div>
@endsection
