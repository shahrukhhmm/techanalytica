@extends('backend.admin.layouts.contentNavbarLayout')
@section('title', 'Category Templates — TA Scoring')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-category text-primary me-2"></i>Category Scoring Templates</h4>
            <p class="text-muted mb-0">Define per-category evaluation requirements. Every template change creates a new version.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-template-modal">
            <i class="bx bx-plus me-1"></i>New Template
        </button>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Version</th>
                            <th>Core Requirements</th>
                            <th>Integrations</th>
                            <th>Target Segments</th>
                            <th>Effective</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $t)
                        <tr>
                            <td class="fw-semibold">{{ $t->category->name ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $t->template_version }}</span></td>
                            <td class="small text-muted">{{ count($t->core_requirements ?? []) }} requirements</td>
                            <td class="small text-muted">{{ count($t->important_integrations ?? []) }} integrations</td>
                            <td class="small">{{ implode(', ', $t->target_segments ?? []) }}</td>
                            <td class="small text-muted">{{ \Carbon\Carbon::parse($t->effective_date)->format('M j, Y') }}</td>
                            <td>
                                @if($t->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Superseded</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">No templates yet. Create the first one to enable category-specific scoring.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($templates->hasPages())
            <div class="card-footer">{{ $templates->links() }}</div>
        @endif
    </div>
</div>

{{-- Add Template Modal --}}
<div class="modal fade" id="add-template-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.scoring.templates.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Category Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select…</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Template Version</label>
                            <input type="text" name="template_version" class="form-control" placeholder="v1.0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Effective Date</label>
                            <input type="date" name="effective_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Core Requirements <small class="text-muted">(one per line — used for Use-Case Fit scoring)</small></label>
                            <textarea name="core_requirements_text" class="form-control" rows="5"
                                placeholder="Content analysis&#10;Keyword/topic analysis&#10;Optimization recommendations&#10;SERP/competitive context&#10;Content scoring/actionable prioritization"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Advanced Capabilities <small class="text-muted">(one per line)</small></label>
                            <textarea name="advanced_capabilities_text" class="form-control" rows="3"
                                placeholder="Briefs&#10;Internal linking&#10;CMS integration"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Important Integrations <small class="text-muted">(one per line — used for Workflow Fit)</small></label>
                            <textarea name="important_integrations_text" class="form-control" rows="3"
                                placeholder="Google Search Console&#10;WordPress&#10;Hubspot"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Target Segments</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach(['solo','smb','mid-market','enterprise'] as $seg)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="target_segments[]" value="{{ $seg }}" id="seg-{{ $seg }}">
                                    <label class="form-check-label" for="seg-{{ $seg }}">{{ ucfirst($seg) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">AI Depth Definition</label>
                            <textarea name="ai_depth_definition" class="form-control" rows="2" placeholder="What substantive AI means for this category…"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
