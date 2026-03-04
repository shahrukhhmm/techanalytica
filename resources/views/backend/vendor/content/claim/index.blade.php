@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Claim your Product')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><span class="text-muted fw-light">Tools /</span> Claim your Product</h4>
        </div>

        <!-- Search Bar -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('vendor.claim') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search for your product by name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="row g-4">
            @forelse($tools as $tool)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                @if ($tool->logo_url)
                                    <img src="{{ asset('storage/' . $tool->logo_url) }}" alt="{{ $tool->name }}"
                                        class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: contain;">
                                @else
                                    <div class="bg-label-primary rounded d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                        style="width: 80px; height: 80px;">
                                        <i class="bx bx-package fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-1">{{ $tool->name }}</h5>
                            <p class="text-muted small mb-3">{{ Str::limit($tool->short_description, 80) }}</p>
                            <a href="{{ route('vendor.claim.create', $tool) }}"
                                class="btn btn-outline-primary btn-sm rounded-pill px-4">Claim this Product</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="avatar avatar-xl bg-label-secondary mx-auto mb-4"
                                style="width: 80px; height: 80px;">
                                <span class="avatar-initial rounded-circle"><i class="bx bx-search-alt fs-1"></i></span>
                            </div>
                            <h4>No products found matching your search</h4>
                            <p class="text-muted mb-4">If you can't find your product, you can list it as a new product
                                listing request.</p>
                            <a href="{{ route('vendor.submit') }}" class="btn btn-primary px-5">List your Product</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $tools->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
