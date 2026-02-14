@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Categories')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Categories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
      <i class="bx bx-plus"></i> Add Category
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
              <th>Parent</th>
              <th>Weight</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
              <tr>
                <td>{{ $category->name }}</td>
                <td><code>{{ $category->slug }}</code></td>
                <td>{{ $category->parent?->name ?? '-' }}</td>
                <td>{{ $category->weight ?? 0 }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-icon btn-outline-primary">
                      <i class="bx bx-edit"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                <td colspan="5" class="text-center">No categories found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
