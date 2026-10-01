@extends('frontend.layout.app')

@section('title', 'Report a Factual Error — ' . $tool->name . ' | TechAnalytica')
@section('description', 'Submit a factual correction or re-evaluation request for ' . $tool->name . ' on TechAnalytica.')

@push('styles')
<style>
.correction-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 48px 0 32px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.correction-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 16px;
    padding: 32px;
    backdrop-filter: blur(8px);
}
.correction-card .form-label { color: var(--text-primary, #fff); font-weight: 600; font-size: 0.875rem; }
.correction-card .form-control,
.correction-card .form-select {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    color: #fff;
    border-radius: 8px;
}
.correction-card .form-control:focus,
.correction-card .form-select:focus {
    background: rgba(255,255,255,0.09);
    border-color: #ff3b7b;
    color: #fff;
    box-shadow: 0 0 0 3px rgba(255,59,123,0.15);
}
.correction-card .form-control::placeholder { color: rgba(255,255,255,0.3); }
.correction-card select option { background: #1a1a2e; color: #fff; }
.ta-principle {
    background: rgba(255,59,123,0.08);
    border: 1px solid rgba(255,59,123,0.2);
    border-radius: 12px;
    padding: 16px;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.75);
}
</style>
@endpush

@section('content')
{{-- Hero --}}
<div class="correction-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($tool->logo_url)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $tool->logo_url }}" alt="{{ $tool->name }}" style="width:48px;height:48px;border-radius:10px;object-fit:contain;background:rgba(255,255,255,0.08);padding:6px;">
                    <div>
                        <div class="text-muted small">Reporting for</div>
                        <h5 class="text-white mb-0 fw-bold">{{ $tool->name }}</h5>
                    </div>
                </div>
                @endif
                <h1 class="text-white fw-bold mb-2" style="font-size:clamp(24px,3vw,36px);">
                    Report a Factual Error or Request Re-evaluation
                </h1>
                <p class="text-muted mb-0">
                    TechAnalytica scores are based on verified evidence. If something is incorrect, we want to know.
                    Submit evidence and our team will review the claim and recalculate the score if warranted.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Form --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            @if(session('success'))
            <div class="alert alert-success mb-4 border-0" style="background:rgba(16,185,129,0.15);color:#6ee7b7;border-radius:12px;">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="ta-principle mb-4">
                <i class="bx bx-shield-check me-2" style="color:#ff3b7b;"></i>
                <strong style="color:#ff3b7b;">TechAnalytica Commercial Integrity Guarantee:</strong><br>
                Paid plans, sponsorships, advertising, and vendor spend <strong>never</strong> change TA Score or organic category rank.
                Corrections affect only factual evidence; the scoring engine recalculates deterministically.
                Every change is logged in our audit trail.
            </div>

            <div class="correction-card">
                <form action="{{ route('frontend.tools.correction.store', $tool) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Type of Correction</label>
                        <select name="correction_type" class="form-select" required id="correction-type">
                            <option value="">Select the type of issue…</option>
                            <option value="incorrect_info" {{ old('correction_type')==='incorrect_info'?'selected':'' }}>Incorrect factual information</option>
                            <option value="feature_change" {{ old('correction_type')==='feature_change'?'selected':'' }}>Feature added or removed</option>
                            <option value="pricing_change" {{ old('correction_type')==='pricing_change'?'selected':'' }}>Pricing changed</option>
                            <option value="integration_change" {{ old('correction_type')==='integration_change'?'selected':'' }}>Integration added or removed</option>
                            <option value="security_compliance" {{ old('correction_type')==='security_compliance'?'selected':'' }}>Security or compliance update</option>
                            <option value="category_fit" {{ old('correction_type')==='category_fit'?'selected':'' }}>Category fit issue</option>
                            <option value="other" {{ old('correction_type')==='other'?'selected':'' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Describe the correction</label>
                        <textarea name="claim" class="form-control" rows="5"
                            placeholder="Please be specific. Example: 'The pricing page shows $49/mo not $99/mo. The integration with HubSpot was launched in August 2026.'"
                            required minlength="20">{{ old('claim') }}</textarea>
                        <small class="text-muted">Minimum 20 characters. Be factual and specific.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Evidence URL <span class="text-muted fw-normal">(optional but strongly recommended)</span></label>
                        <input type="url" name="evidence_url" class="form-control"
                            placeholder="https://vendor.com/pricing or https://docs.vendor.com/…"
                            value="{{ old('evidence_url') }}">
                        <small class="text-muted">Link to the vendor's official page that supports your claim.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Supporting File <span class="text-muted fw-normal">(PDF, PNG, JPG — max 5MB, optional)</span></label>
                        <input type="file" name="evidence_file" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3" style="border-radius:10px;background:linear-gradient(90deg,#ff3b7b,#ff735c);border:none;font-weight:700;">
                        <i class="bx bx-send me-2"></i>Submit Correction Request
                    </button>
                </form>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small mb-2">What happens next?</p>
                <div class="d-flex justify-content-center gap-4 flex-wrap" style="font-size:0.8rem;color:rgba(255,255,255,0.5);">
                    <div><i class="bx bx-search me-1" style="color:#ff3b7b;"></i>We review the evidence</div>
                    <div><i class="bx bx-data me-1" style="color:#ff3b7b;"></i>Facts are updated if valid</div>
                    <div><i class="bx bx-calculator me-1" style="color:#ff3b7b;"></i>Score recalculates automatically</div>
                    <div><i class="bx bx-bell me-1" style="color:#ff3b7b;"></i>You're notified of the outcome</div>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('frontend.tools.show', $tool->slug) }}" class="text-muted small">
                    <i class="bx bx-arrow-back me-1"></i>Back to {{ $tool->name }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
