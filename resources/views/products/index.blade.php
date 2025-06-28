@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Products</h2>

    <!-- Add Button -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Price</th><th>Stock</th><th>Category</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>Rs. {{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-stock="{{ $product->stock }}"
                        data-category="{{ $product->category_id }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editProductModal">Edit</button>

                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('products.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editProductForm" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Price</label>
                    <input type="number" name="price" id="editPrice" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Stock</label>
                    <input type="number" name="stock" id="editStock" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Category</label>
                    <select name="category_id" id="editCategory" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = this.dataset.price;
            const stock = this.dataset.stock;
            const category = this.dataset.category;

            const form = document.getElementById('editProductForm');
            form.action = `/products/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editStock').value = stock;
            document.getElementById('editCategory').value = category;
        });
    });
</script>
@endsection
