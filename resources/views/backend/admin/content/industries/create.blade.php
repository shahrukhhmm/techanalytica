@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Create Industry')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Create Industry</h4>
    <a href="{{ route('admin.industries.index') }}" class="btn btn-secondary">
      <i class="bx bx-arrow-back"></i> Back
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.industries.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
          <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" 
                 id="name" name="name" value="{{ old('name') }}" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                 id="slug" name="slug" value="{{ old('slug') }}" 
                 placeholder="Leave empty to auto-generate">
          <small class="text-muted">Leave empty to auto-generate from name</small>
          @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" 
                    id="description" name="description" rows="3">{{ old('description') }}</textarea>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="suggested_by_vendor_id" class="form-label">Suggested By Vendor</label>
          <select class="form-select @error('suggested_by_vendor_id') is-invalid @enderror" 
                  id="suggested_by_vendor_id" name="suggested_by_vendor_id">
            <option value="">None</option>
            @foreach($vendors as $vendor)
              <option value="{{ $vendor->id }}" {{ old('suggested_by_vendor_id') == $vendor->id ? 'selected' : '' }}>
                {{ $vendor->company_name }} ({{ $vendor->user->name ?? 'N/A' }})
              </option>
            @endforeach
          </select>
          @error('suggested_by_vendor_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Create Industry</button>
          <a href="{{ route('admin.industries.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
