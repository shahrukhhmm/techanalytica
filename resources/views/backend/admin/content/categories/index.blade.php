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
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
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
            <h4 class="fw-bold">
                @if (request('category'))
                    <span class="text-muted fw-light">Categories /</span> {{ request('category') }} Subcategories
                @else
                    Categories
                @endif
            </h4>
            <div class="d-flex gap-2">
                @if (request('category'))
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Back to Root
                    </a>
                @endif
                <a href="{{ route('admin.categories.create', $currentParent ? ['parent_id' => $currentParent->id] : []) }}"
                    class="btn btn-primary">
                    <i class="bx bx-plus"></i> Add {{ $currentParent ? 'Subcategory' : 'Category' }}
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Items</th>
                                <th>Weight</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $category->name }}</div>
                                        @if (!$category->parent_id && $category->children_count > 0)
                                            <small class="text-info">{{ $category->children_count }} subcategories</small>
                                        @endif
                                    </td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>
                                        <span class="badge bg-label-secondary">
                                            {{ $category->children_count }} Sub
                                        </span>
                                    </td>
                                    <td>{{ $category->weight }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if ($category->children_count > 0 || !$category->parent_id)
                                                <a href="{{ route('admin.categories.index', ['category' => $category->name]) }}"
                                                    class="btn btn-sm btn-icon btn-outline-info" title="View Subcategories">
                                                    <i class="bx bx-list-ul"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                                                    title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        new DataTable('#table');
                    });
                </script>
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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="modal_name"
                                name="name" value="{{ old('name') }}" required placeholder="Enter subcategory name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="modal_description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="modal_description" name="description"
                                rows="3" placeholder="Enter optional description">{{ old('description') }}</textarea>
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
                collapse.addEventListener('show.bs.collapse', function() {
                    const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
                    if (button) {
                        button.querySelector('i').classList.replace('bx-chevron-right',
                            'bx-chevron-down');
                        button.classList.replace('btn-outline-secondary', 'btn-primary text-white');
                    }
                });
                collapse.addEventListener('hide.bs.collapse', function() {
                    const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
                    if (button) {
                        button.querySelector('i').classList.replace('bx-chevron-down',
                            'bx-chevron-right');
                        button.classList.replace('btn-primary', 'btn-outline-secondary');
                        button.classList.remove('text-white');
                    }
                });
            });

            // Modal Setup
            const addSubcategoryModal = document.getElementById('addSubcategoryModal');
            if (addSubcategoryModal) {
                addSubcategoryModal.addEventListener('show.bs.modal', function(event) {
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
            @if ($errors->any())
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
