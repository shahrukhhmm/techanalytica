@extends('backend.admin.layouts.contentNavbarLayout')

@section('title', 'Categories')

@section('page-style')
<style>
  .subcategory-expanded-row {
    background-color: #fafbfc;
  }
  .subcategory-container {
      padding: 1.5rem 2rem;
      border-left: 4px solid #1c96ed;
      margin: 10px 10px 10px 40px;
      background: white;
      border-radius: 0 8px 8px 0;
      box-shadow: 0 2px 15px rgba(0,0,0,0.05);
  }
  .subcategory-table thead {
      background-color: #f0f7ff;
  }
  .subcategory-table th {
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      color: #5b6e88;
      border-top: none !important;
  }
  .subcategory-title {
      color: #1c96ed;
      font-weight: 600;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
  }
  .subcategory-title i {
      font-size: 1.2rem;
  }
</style>
@endsection

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
              <th width="50"></th>
              <th>Name</th>
              <th>Slug</th>
              <th>Weight</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rootCategories as $category)
              <tr>
                <td>
                    <button class="btn btn-sm btn-icon btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#subcategories-{{ $category->id }}" aria-expanded="false">
                      <i class="bx bx-chevron-right"></i>
                    </button>
                </td>
                <td>
                  <i class="bx bx-folder text-primary me-2"></i>
                  <strong>{{ $category->name }}</strong>
                    <span class="badge bg-label-primary ms-2">{{ $category->children->count() }} sub-categories</span>
                </td>
                <td><code>{{ $category->slug }}</code></td>
                <td>{{ $category->weight ?? 0 }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                      <i class="bx bx-edit"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the category and ALL its sub-categories.')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Delete">
                        <i class="bx bx-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              
                <tr class="collapse subcategory-expanded-row" id="subcategories-{{ $category->id }}">
                  <td colspan="5" class="p-0 border-0">
                    <div class="subcategory-container">
                      <div class="subcategory-title justify-content-between">
                        <div>
                          <i class="bx bx-subdirectory-right me-2"></i>
                          Sub-categories of {{ $category->name }}
                        </div>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-success btn-add-subcategory" 
                                data-bs-toggle="modal" data-bs-target="#addSubcategoryModal" 
                                data-parent-id="{{ $category->id }}" 
                                data-parent-name="{{ $category->name }}" 
                                title="Add Sub-category">
                          <i class="bx bx-plus"></i>
                        </button>
                      </div>
                      <table class="table table-sm subcategory-table mb-0">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th class="text-center">Weight</th>
                            <th class="text-end">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($category->children as $child)
                            <tr>
                              <td class="py-2">
                                <span class="fw-medium text-dark">{{ $child->name }}</span>
                              </td>
                              <td class="py-2"><code>{{ $child->slug }}</code></td>
                              <td class="py-2 text-center">{{ $child->weight ?? 0 }}</td>
                              <td class="py-2">
                                <div class="d-flex gap-2 justify-content-end">
                                  <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-xs btn-icon btn-outline-primary" title="Edit">
                                    <i class="bx bx-edit" style="font-size: 0.85rem;"></i>
                                  </a>
                                  <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-icon btn-outline-danger" title="Delete">
                                      <i class="bx bx-trash" style="font-size: 0.85rem;"></i>
                                    </button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
              
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No categories found. Start by adding one!</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Subcategory Modal -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-start">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-bold" id="modalTitle">Add Subcategory</h5>
      </div>
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <input type="hidden" name="parent_id" id="modal_parent_id">
        
        <div class="modal-body">
          <div class="alert alert-primary d-flex align-items-center mb-4" role="alert">
            <i class="bx bx-info-circle me-2"></i>
            <div>
              Creating subcategory under: <strong id="modal_parent_name"></strong>
            </div>
          </div>

          <div class="mb-3">
            <label for="modal_name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="modal_name" name="name" value="{{ old('name') }}" required placeholder="Enter subcategory name">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="modal_description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="modal_description" name="description" rows="3" placeholder="Enter optional description">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-0">
            <label for="modal_weight" class="form-label">Weight</label>
            <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                   id="modal_weight" name="weight" value="{{ old('weight', 0) }}">
            @error('weight')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer border-top mt-2">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Subcategory</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle Collapse Icons
  const collapses = document.querySelectorAll('.collapse');
  collapses.forEach(collapse => {
    collapse.addEventListener('show.bs.collapse', function () {
      const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
      if (button) {
        button.querySelector('i').classList.replace('bx-chevron-right', 'bx-chevron-down');
        button.classList.replace('btn-outline-secondary', 'btn-primary text-white');
      }
    });
    collapse.addEventListener('hide.bs.collapse', function () {
      const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
      if (button) {
        button.querySelector('i').classList.replace('bx-chevron-down', 'bx-chevron-right');
        button.classList.replace('btn-primary', 'btn-outline-secondary');
        button.classList.remove('text-white');
      }
    });
  });

  // Modal Setup
  const addSubcategoryModal = document.getElementById('addSubcategoryModal');
  if (addSubcategoryModal) {
    addSubcategoryModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const parentId = button.getAttribute('data-parent-id');
      const parentName = button.getAttribute('data-parent-name');

      const modalInputParentId = addSubcategoryModal.querySelector('#modal_parent_id');
      const modalSpanParentName = addSubcategoryModal.querySelector('#modal_parent_name');
      const modalHeaderTitle = addSubcategoryModal.querySelector('#modalTitle');

      modalInputParentId.value = parentId;
      modalSpanParentName.textContent = parentName;
      modalHeaderTitle.textContent = `Add Subcategory to ${parentName}`;
    });
  }

  // Automatically open modal if there are validation errors
  @if($errors->any())
    const modal = new bootstrap.Modal(document.getElementById('addSubcategoryModal'));
    modal.show();
    
    // If we had a parent_id from old input, we should probably set it back
    const oldParentId = "{{ old('parent_id') }}";
    if (oldParentId) {
        document.getElementById('modal_parent_id').value = oldParentId;
        // Note: setting parent name would be tricky without JS object of all categories, 
        // but since the link usually provides it, it will be set by the event listener if triggered by button.
        // On refresh with errors, we might need a way to restore the name.
        // For now, if it's a redirect-back with errors, the user is likely already looking at the modal.
    }
  @endif
});
</script>
@endsection
