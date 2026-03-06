@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'User Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold"><span class="text-muted fw-light">Users /</span> User Details</h4>

        <div class="row">
            <!-- User Details -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar avatar-xl mb-3">
                                    <span
                                        class="avatar-initial rounded-circle bg-label-primary">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{ $user->name }}</h4>
                                    <span class="badge bg-label-secondary text-capitalize">{{ $user->role }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                            <div class="d-flex align-items-start me-4 mt-3 gap-3">
                                <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-check bx-sm"></i></span>
                                <div>
                                    <h5 class="mb-0">{{ $user->blogs_count ?? $user->blogs->count() }}</h5>
                                    <span>Blogs</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3 gap-3">
                                <span class="badge bg-label-primary p-2 rounded"><i
                                        class="bx bx-customize bx-sm"></i></span>
                                <div>
                                    <h5 class="mb-0">{{ $user->vendor ? '1' : '0' }}</h5>
                                    <span>Vendor Profile</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-2 border-bottom mb-4">Details</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Username:</span>
                                    <span>{{ $user->name }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Email:</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Status:</span>
                                    @if ($user->is_suspended)
                                        <span class="badge bg-label-danger">Suspended</span>
                                    @else
                                        <span class="badge bg-label-success">Active</span>
                                    @endif
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Role:</span>
                                    <span class="text-capitalize">{{ $user->role }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">Verified:</span>
                                    <span>{{ $user->email_verified_at ? 'Yes' : 'No' }}</span>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center pt-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-3">Edit</a>
                                <form action="{{ route('admin.users.toggle-suspension', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-label-danger suspend-user">{{ $user->is_suspended ? 'Unsuspend' : 'Suspend' }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-vendor" aria-controls="navs-pills-top-vendor"
                                aria-selected="true">Vendor Details</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-blogs" aria-controls="navs-pills-top-blogs"
                                aria-selected="false">Recent Blogs</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-top-vendor" role="tabpanel">
                            @if ($user->vendor)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Company Name</label>
                                        <p>{{ $user->vendor->company_name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Company Website</label>
                                        <p><a href="{{ $user->vendor->company_website }}"
                                                target="_blank">{{ $user->vendor->company_website }}</a></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <p>{{ $user->vendor->phone }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Billing Email</label>
                                        <p>{{ $user->vendor->billing_email }}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('admin.vendors.show', $user->vendor) }}"
                                        class="btn btn-outline-primary btn-sm">View Full Vendor Profile</a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted">This user does not have a vendor profile.</p>
                                    @if ($user->role == 'vendor')
                                        <a href="{{ route('admin.vendors.create', ['user_id' => $user->id]) }}"
                                            class="btn btn-primary btn-sm">Create Vendor Profile</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="navs-pills-top-blogs" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Published At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->blogs()->latest()->take(5)->get() as $blog)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.blogs.show', $blog) }}">{{ Str::limit($blog->title, 40) }}</a>
                                                </td>
                                                <td><span
                                                        class="badge bg-label-{{ $blog->status == 'published' ? 'success' : 'warning' }}">{{ $blog->status }}</span>
                                                </td>
                                                <td>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No blogs found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
