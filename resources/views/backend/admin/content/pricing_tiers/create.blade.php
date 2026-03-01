@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Manage Pricing Tier')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">
            <span class="text-muted fw-light">Pricing Tiers /</span> {{ isset($pricing_tier) ? 'Edit' : 'Create' }}
        </h4>

        <div class="row">
            <div class="col-md-10 mx-auto">
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

                                <div class="col-md-6 mb-4">
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
                                                <button type="button" class="btn btn-outline-danger remove-item"><i
                                                        class="bx bx-x"></i></button>
                                            </div>
                                        @else
                                            @foreach ($features as $feature)
                                                <div class="feature-item input-group mb-2">
                                                    <input type="text" name="features[]" class="form-control"
                                                        value="{{ $feature }}"
                                                        placeholder="Enter feature description...">
                                                    <button type="button" class="btn btn-outline-danger remove-item"><i
                                                            class="bx bx-x"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" id="add-feature" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="bx bx-plus me-1"></i> Add Feature
                                    </button>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold d-block mb-2">Permissions List</label>
                                    <div id="permissions-container">
                                        @php
                                            $permissions = old(
                                                'permissions',
                                                isset($pricing_tier) ? $pricing_tier->permissions : [],
                                            );
                                            $defaultPermissions = [
                                                'Basic Listing',
                                                'Analytics Dashboard',
                                                'Featured Listing',
                                                'Verified Badge',
                                                'Newsletter Mention',
                                                'Priority Support',
                                            ];

                                            if (empty($permissions) && !isset($pricing_tier)) {
                                                $permissions = [];
                                            }
                                        @endphp

                                        @if (empty($permissions))
                                            <div class="permission-item input-group mb-2">
                                                <input type="text" name="permissions[]" class="form-control"
                                                    placeholder="Enter permission description...">
                                                <button type="button" class="btn btn-outline-danger remove-item"><i
                                                        class="bx bx-x"></i></button>
                                            </div>
                                        @else
                                            @foreach ($permissions as $permission)
                                                <div class="permission-item input-group mb-2">
                                                    <input type="text" name="permissions[]" class="form-control"
                                                        value="{{ $permission }}"
                                                        placeholder="Enter permission description...">
                                                    <button type="button" class="btn btn-outline-danger remove-item"><i
                                                            class="bx bx-x"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" id="add-permission" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-plus me-1"></i> Add Permission
                                        </button>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted d-block mb-2">Common Permissions:</small>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($defaultPermissions as $dp)
                                                <button type="button"
                                                    class="btn btn-xs btn-label-secondary add-preset-permission"
                                                    data-permission="{{ $dp }}">
                                                    {{ $dp }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
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

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const featuresContainer = document.getElementById('features-container');
            const addFeatureButton = document.getElementById('add-feature');
            const permissionsContainer = document.getElementById('permissions-container');
            const addPermissionButton = document.getElementById('add-permission');

            // Function to add new input field
            function addItem(container, name, placeholder) {
                const div = document.createElement('div');
                div.className = `${name}-item input-group mb-2`;
                div.innerHTML = `
                    <input type="text" name="${name}s[]" class="form-control" placeholder="${placeholder}">
                    <button type="button" class="btn btn-outline-danger remove-item"><i class="bx bx-x"></i></button>
                `;
                container.appendChild(div);
                div.querySelector('input').focus();
            }

            // Add Feature
            addFeatureButton.addEventListener('click', function() {
                addItem(featuresContainer, 'feature', 'Enter feature description...');
            });

            // Add Permission
            addPermissionButton.addEventListener('click', function() {
                addItem(permissionsContainer, 'permission', 'Enter permission description...');
            });

            // Handle Remove and Presets
            document.addEventListener('click', function(e) {
                // Remove Item
                if (e.target.closest('.remove-item')) {
                    const item = e.target.closest('.input-group');
                    const container = item.parentElement;
                    if (container.querySelectorAll('.input-group').length > 1) {
                        item.remove();
                    } else {
                        item.querySelector('input').value = '';
                    }
                }

                // Add Preset Permission
                if (e.target.closest('.add-preset-permission')) {
                    const presetBtn = e.target.closest('.add-preset-permission');
                    const permissionText = presetBtn.dataset.permission;

                    // Check if we have an empty input to fill
                    const inputs = permissionsContainer.querySelectorAll('input[name="permissions[]"]');
                    let filled = false;

                    for (let input of inputs) {
                        if (input.value.trim() === '') {
                            input.value = permissionText;
                            filled = true;
                            break;
                        }
                    }

                    if (!filled) {
                        const div = document.createElement('div');
                        div.className = 'permission-item input-group mb-2';
                        div.innerHTML = `
                                <input type="text" name="permissions[]" class="form-control" value="${permissionText}">
                                <button type="button" class="btn btn-outline-danger remove-item"><i class="bx bx-x"></i></button>
                            `;
                        permissionsContainer.appendChild(div);
                    }
                }
            });
        });
    </script>
@endsection
@endsection
