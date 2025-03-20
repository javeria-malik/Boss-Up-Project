@extends('admin.layout.master')

@section('content')
    <div class="container-fluid my-4">
        <h1 class="text-center mb-4">Products</h1>

        <div class="d-flex justify-content-between align-items-center mb-3 px-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a>
            
            <!-- Category Filter Dropdown -->
            <div class="d-flex align-items-center" style="max-width: 250px; width: 100%;">
            <form method="GET" action="{{ route('products.index') }}">
    <div class="d-flex align-items-center" style="max-width: 250px; width: 100%;">
        <select name="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">Select Category</option>
            @foreach($categories->where('parent_id', null) as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
</form>

            </div>

            <!-- Filter and Search Section -->
            <div class="d-flex flex-column" style="width: 250px;">
                <div class="dropdown mb-2">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Filter Products
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">Without Trash</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.with-trash') }}">With Trash</a></li>
                    </ul>
                </div>

                <!-- Search Bar -->
                <div class="input-group">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                        <input type="hidden" name="trash" value="{{ request()->query('trash') }}">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->query('search') }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive px-3">
            <table class="table table-hover text-nowrap w-100">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Best Seller</th>
                        <th>New Arrival</th>
                        <th>Hot Sale</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    @foreach ($products as $product)
                        <tr> 
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ Str::limit($product->description, 50, '...') }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="80" class="img-thumbnail">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ number_format($product->quantity) }}</td>
                            <td>
                                <span class="badge {{ $product->is_best_seller ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_best_seller ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $product->is_new_arrival ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_new_arrival ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $product->is_hot_sale ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_hot_sale ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                @if($product->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->trashed())
                                    <!-- Restore Button -->
                                    <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-link text-success" style="padding: 0;">
                                            <i class="fas fa-recycle"></i> Restore
                                        </button>
                                    </form>

                                    <!-- Force Delete Button -->
                                    <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger" style="padding: 0;" onclick="return confirm('Are you sure you want to permanently delete this product?');">
                                            <i class="fas fa-trash-alt"></i> Force Delete
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('products.edit', $product->slug) }}" class="text-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Soft Delete Button -->
                                    <form action="{{ route('products.destroy', $product->slug) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger" style="padding: 0;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
