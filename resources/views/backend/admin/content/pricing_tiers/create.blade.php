@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Manage Pricing Tier')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">
            <span class="text-muted fw-light">Pricing Tiers /</span> {{ isset($pricing_tier) ? 'Edit' : 'Create' }}
        </h4>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light border-bottom py-3">
                        <h5 class="mb-0 fw-bold">{{ isset($pricing_tier) ? 'Edit Tier Details' : 'New Pricing Tier' }}</h5>
                    </div>
                    <div class="card-body pt-4">
                        <form
                            action="{{ isset($pricing_tier) ? route('admin.pricing-tiers.update', $pricing_tier) : route('admin.pricing-tiers.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($pricing_tier))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold" for="name">Tier Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $pricing_tier->name ?? '') }}"
                                        placeholder="e.g., Professionals, Enterprise" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold" for="monthly_price">Monthly Price ($)</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('monthly_price') is-invalid @enderror" id="monthly_price"
                                        name="monthly_price"
                                        value="{{ old('monthly_price', $pricing_tier->monthly_price ?? '0.00') }}"
                                        placeholder="0.00">
                                    @error('monthly_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold" for="annual_price">Annual Price ($)</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('annual_price') is-invalid @enderror" id="annual_price"
                                        name="annual_price"
                                        value="{{ old('annual_price', $pricing_tier->annual_price ?? '0.00') }}"
                                        placeholder="0.00">
                                    @error('annual_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold d-block mb-2">Features List</label>
                                    <div id="features-container">
                                        @php
                                            $features = old(
                                                'features',
                                                isset($pricing_tier) ? $pricing_tier->features : [],
                                            );
                                        @endphp
                                        @if (empty($features))
                                            <div class="feature-item input-group mb-2">
                                                <input type="text" name="features[]" class="form-control"
                                                    placeholder="Enter feature description...">
                                                <button type="button" class="btn btn-outline-danger remove-feature"><i
                                                        class="bx bx-x"></i></button>
                                            </div>
                                        @else
                                            @foreach ($features as $feature)
                                                <div class="feature-item input-group mb-2">
                                                    <input type="text" name="features[]" class="form-control"
                                                        value="{{ $feature }}"
                                                        placeholder="Enter feature description...">
                                                    <button type="button" class="btn btn-outline-danger remove-feature"><i
                                                            class="bx bx-x"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" id="add-feature" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="bx bx-plus me-1"></i> Add Feature
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 border-top pt-4">
                                <a href="{{ route('admin.pricing-tiers.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit"
                                    class="btn btn-primary px-5">{{ isset($pricing_tier) ? 'Update Tier' : 'Create Tier' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page-script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('features-container');
                const addButton = document.getElementById('add-feature');

                addButton.addEventListener('click', function() {
                    const div = document.createElement('div');
                    div.className = 'feature-item input-group mb-2';
                    div.innerHTML = `
                    <input type="text" name="features[]" class="form-control" placeholder="Enter feature description...">
                    <button type="button" class="btn btn-outline-danger remove-feature"><i class="bx bx-x"></i></button>
                `;
                    container.appendChild(div);
                });

                container.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-feature')) {
                        const item = e.target.closest('.feature-item');
                        if (container.querySelectorAll('.feature-item').length > 1) {
                            item.remove();
                        } else {
                            item.querySelector('input').value = '';
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
