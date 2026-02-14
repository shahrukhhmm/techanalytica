@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Industries')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Industries</h4>
    <a href="{{ route('admin.industries.create') }}" class="btn btn-primary">
      <i class="bx bx-plus"></i> Add Industry
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Slug</th>
              <th>Suggested By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($industries as $industry)
              <tr>
                <td>{{ $industry->name }}</td>
                <td><code>{{ $industry->slug }}</code></td>
                <td>{{ $industry->suggestedByVendor?->company_name ?? '-' }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('admin.industries.edit', $industry) }}" class="btn btn-sm btn-icon btn-outline-primary">
                      <i class="bx bx-edit"></i>
                    </a>
                    <form action="{{ route('admin.industries.destroy', $industry) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-icon btn-outline-danger">
                        <i class="bx bx-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No industries found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
