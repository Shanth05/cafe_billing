@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Categories</h2>

    <!-- Add Category Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add Category</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Categories Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <!-- Edit Button triggers modal -->
                        <button class="btn btn-sm btn-warning editBtn"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editCategoryModal">
                            Edit
                        </button>

                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('categories.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="text" name="name" class="form-control" placeholder="Category name" required>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success">Save</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
  </div>
</div>

<!-- Edit Modal (shared, dynamic) -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editCategoryForm" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="text" name="name" id="editCategoryName" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning" type="submit">Update</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
  </div>
</div>

<!-- Bootstrap & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Fill Edit Modal with category data
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;

            const form = document.getElementById('editCategoryForm');
            form.action = `/categories/${id}`; // Set dynamic route
            document.getElementById('editCategoryName').value = name;
        });
    });
</script>
@endsection
