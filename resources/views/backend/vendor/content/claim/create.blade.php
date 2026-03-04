@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Claim Product: ' . $tool->name)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-label-primary p-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-white rounded p-2 me-3 shadow-sm">
                                @if ($tool->logo_url)
                                    <img src="{{ asset('storage/' . $tool->logo_url) }}" alt="{{ $tool->name }}"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <i class="bx bx-package fs-2 text-primary"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold text-primary">Claiming: {{ $tool->name }}</h4>
                                <p class="mb-0 opacity-75">Verify your relationship with this product</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-5">
                        <form action="{{ route('vendor.claim.store', $tool) }}" method="POST">
                            @csrf
                            <div class="alert alert-info border-0 bg-label-info d-flex mb-4" role="alert">
                                <span class="badge badge-center rounded-pill bg-info h-px-20 w-px-20 me-2"><i
                                        class="bx bx-info-circle"></i></span>
                                <div>
                                    <h6 class="alert-heading fw-bold mb-1">Instant Approval Tips:</h6>
                                    <p class="mb-0 small">Use your business email associated with
                                        <strong>{{ parse_url($tool->website_url, PHP_URL_HOST) }}</strong> for automatic
                                        verification.</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="business_email" class="form-label">Business Email</label>
                                <input type="email" class="form-control @error('business_email') is-invalid @enderror"
                                    id="business_email" name="business_email" placeholder="you@yourcompany.com"
                                    value="{{ old('business_email', auth()->user()->email) }}" required>
                                @error('business_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2">We'll send a verification link or reach out if we need more
                                    info.</div>
                            </div>

                            <div class="mb-4">
                                <label for="reason" class="form-label">Your Role / Reason for Claiming</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4"
                                    placeholder="e.g., I am the Product Manager at this company and would like to manage our profile..." required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <a href="{{ route('vendor.claim') }}" class="btn btn-label-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5">Submit Claim</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-muted small">By submitting this claim, you agree to our <a href="#">Vendor Terms of
                            Service</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
