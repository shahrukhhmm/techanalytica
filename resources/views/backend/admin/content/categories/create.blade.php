@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Create Category')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Create Category</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
      <i class="bx bx-arrow-back"></i> Back
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.categories.store') }}" method="POST">
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
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" 
                    id="description" name="description" rows="3">{{ old('description') }}</textarea>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="parent_id" class="form-label">Parent Category</label>
          <select class="form-select @error('parent_id') is-invalid @enderror" 
                  id="parent_id" name="parent_id">
            <option value="">None</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('parent_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="weight" class="form-label">Weight</label>
          <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                 id="weight" name="weight" value="{{ old('weight', 0) }}">
          @error('weight')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Create Category</button>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
