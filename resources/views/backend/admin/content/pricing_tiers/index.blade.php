@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Pricing Tiers')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Pricing Tiers</h4>
            <a href="{{ route('admin.pricing-tiers.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add Tier
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @forelse ($tiers as $tier)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">{{ $tier->name }}</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon btn-link text-muted p-0" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item"
                                                href="{{ route('admin.pricing-tiers.edit', $tier) }}"><i
                                                    class="bx bx-edit-alt me-2"></i> Edit</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.pricing-tiers.destroy', $tier) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i
                                                        class="bx bx-trash me-2"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-4">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold mb-1">${{ number_format($tier->monthly_price, 2) }}<span
                                        class="fs-6 text-muted fw-normal">/mo</span></h2>
                                <p class="text-muted small">${{ number_format($tier->annual_price, 2) }} / year</p>
                            </div>
                            <ul class="list-unstyled mb-0">
                                @if ($tier->features)
                                    @foreach ($tier->features as $feature)
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="bx bx-check text-success me-2 mt-1"></i>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-muted text-center italic">No features defined.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">No pricing tiers found. Click "Add Tier" to create one.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
