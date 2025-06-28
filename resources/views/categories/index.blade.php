@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Categories</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <!-- Left side (empty or add filters/search if needed) -->
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Categories Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-warning editBtn"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editCategoryModal">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger deleteBtn"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCategoryModal">
                            Delete
                        </button>
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
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control" placeholder="Category name" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCategoryForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name" id="editCategoryName" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="deleteCategoryForm" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the category "<span id="deleteCategoryName"></span>"?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap & JS -->
@vite(['resources/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fill Edit Modal
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const form = document.getElementById('editCategoryForm');
                form.action = `/categories/${id}`;
                document.getElementById('editCategoryName').value = name;
            });
        });

        // Fill Delete Modal
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const form = document.getElementById('deleteCategoryForm');
                form.action = `/categories/${id}`;
                document.getElementById('deleteCategoryName').textContent = name;
            });
        });
    });
</script>
@endsection