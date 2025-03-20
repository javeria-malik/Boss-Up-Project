@extends('admin.layout.master')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Create New Product</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Product Creation Form -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="form-group mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Enter product title">
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required placeholder="Enter product description">{{ old('description') }}</textarea>
            </div>

            <!-- Price -->
            <div class="form-group mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" required placeholder="Enter product price">
            </div>
             <!-- quantity -->
            <div class="form-group mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}" step="0.01" required placeholder="Enter product quantity">
            </div>
            <div>
    <label for="category">Select Category:</label>
    <select name="category_id" required>
        <option value="">-- Choose Category --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

            </div>
            
            <div class="form-group">
               <label for="status">Status</label>
               <select name="status" id="status" class="form-control">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
               </select>
            </div>
             

            <!-- Image -->
            <div class="form-group mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <!-- Checkboxes -->
            <div class="form-check mb-2">
                <input type="checkbox" name="is_best_seller" id="is_best_seller" class="form-check-input" {{ old('is_best_seller') ? 'checked' : '' }}>
                <label for="is_best_seller" class="form-check-label">Best Seller</label>
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" name="is_new_arrival" id="is_new_arrival" class="form-check-input" {{ old('is_new_arrival') ? 'checked' : '' }}>
                <label for="is_new_arrival" class="form-check-label">New Arrival</label>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" name="is_hot_sale" id="is_hot_sale" class="form-check-input" {{ old('is_hot_sale') ? 'checked' : '' }}>
                <label for="is_hot_sale" class="form-check-label">Hot Sale</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Create Product</button>
        </form>
    </div>
@endsection
