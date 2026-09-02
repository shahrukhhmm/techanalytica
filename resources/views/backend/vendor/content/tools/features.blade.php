@extends('backend.vendor.layouts.contentNavbarLayout')

@section('title', 'Product Features & Capabilities')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Products /</span> Features & Advantages</h4>
                <p class="text-muted small mb-0">Highlight the architectural strengths, key features, and capabilities of your product.</p>
            </div>
            @if ($tools->count() > 1)
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bx bx-wrench me-1"></i> Managing: <strong>{{ $tool->name }}</strong>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($tools as $t)
                            <li>
                                <a class="dropdown-item {{ $t->id === $tool->id ? 'active' : '' }}"
                                    href="{{ route('vendor.switch-tool', $t->id) }}">
                                    {{ $t->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom py-3 bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bx bx-check-double me-1 text-primary"></i> Features, Pros & Cons for {{ $tool->name }}</h5>
                        <span class="badge bg-label-info">{{ $tool->ai_type ?? 'AI Tool' }}</span>
                    </div>
                    <div class="card-body pt-4">
                        <form action="{{ route('vendor.features.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tool_id" value="{{ $tool->id }}">

                            <!-- Short Pitch -->
                            <div class="mb-4">
                                <label for="short_description" class="form-label fw-bold">Short Capability Summary</label>
                                <textarea class="form-control" id="short_description" name="short_description" rows="2"
                                    placeholder="Brief 1-2 sentence highlight of what makes this AI tool powerful.">{{ old('short_description', $tool->short_description) }}</textarea>
                            </div>

                            <!-- Pros & Cons Grid -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label text-success fw-bold">
                                        <i class="bx bx-check-circle me-1"></i> Key Strengths & Pros
                                    </label>
                                    <div id="vendor-pros-container">
                                        @php
                                            $prosList = old('pros', $tool->pros ?? ['High scalability and low inference latency', 'Native API & Webhook support']);
                                        @endphp
                                        @foreach ($prosList as $pro)
                                            <div class="input-group mb-2 pro-item">
                                                <input type="text" name="pros[]" class="form-control form-control-sm"
                                                    value="{{ $pro }}" placeholder="e.g. Real-time streaming API">
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.pro-item').remove()">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-success mt-1" onclick="addProItem()">
                                        <i class="bx bx-plus me-1"></i> Add Strength
                                    </button>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-warning fw-bold">
                                        <i class="bx bx-info-circle me-1"></i> Considerations & Limitations (Cons)
                                    </label>
                                    <div id="vendor-cons-container">
                                        @php
                                            $consList = old('cons', $tool->cons ?? ['Requires onboarding for complex custom datasets']);
                                        @endphp
                                        @foreach ($consList as $con)
                                            <div class="input-group mb-2 con-item">
                                                <input type="text" name="cons[]" class="form-control form-control-sm"
                                                    value="{{ $con }}" placeholder="e.g. Free tier has rate limits">
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.con-item').remove()">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-warning mt-1" onclick="addConItem()">
                                        <i class="bx bx-plus me-1"></i> Add Consideration
                                    </button>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Detailed Architecture Overview -->
                            <div class="mb-4">
                                <label for="long_description" class="form-label fw-bold">Detailed Technical Overview & Architecture</label>
                                <textarea class="form-control" id="long_description" name="long_description" rows="6"
                                    placeholder="Explain your model architecture, integrations, security compliance (SOC2/GDPR), and enterprise capabilities.">{{ old('long_description', $tool->long_description) }}</textarea>
                                <small class="text-muted">Supports comprehensive technical write-ups rendered on your product's deep-dive overview tab.</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2 border-top pt-3">
                                <a href="{{ route('vendor.tools.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Save Features & Strengths
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Side Info -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4 bg-label-info">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2"><i class="bx bx-star me-1"></i> Why Pros & Cons Matter</h6>
                        <p class="small text-muted mb-3">
                            Comparison algorithms and buyer evaluation matrixes rely on verified pros and cons to recommend tools in side-by-side benchmarks.
                        </p>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><i class="bx bx-check text-info me-1"></i> Tools with 3+ pros receive 40% higher buyer engagement.</li>
                            <li class="mb-0"><i class="bx bx-check text-info me-1"></i> Balanced considerations increase buyer conversion trust.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addProItem() {
            const container = document.getElementById('vendor-pros-container');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 pro-item';
            div.innerHTML = `
                <input type="text" name="pros[]" class="form-control form-control-sm" placeholder="Enter key strength">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.pro-item').remove()">
                    <i class="bx bx-x"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addConItem() {
            const container = document.getElementById('vendor-cons-container');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 con-item';
            div.innerHTML = `
                <input type="text" name="cons[]" class="form-control form-control-sm" placeholder="Enter limitation or note">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.con-item').remove()">
                    <i class="bx bx-x"></i>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
@endsection
