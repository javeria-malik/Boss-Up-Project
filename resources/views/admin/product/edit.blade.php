@extends('admin.layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="bg-white p-4 shadow-sm rounded">
        <h1 class="text-center mb-4">Edit Product</h1>
            
            <form action="{{ route('products.update', $product->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Product Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $product->title }}" required>

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity}}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                </div>
                <div class="form-group">
                   <label for="status">Status</label>
                   <select name="status" id="status" class="form-control">
                      <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>


                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if ($product->image)
                            <div class="mt-2">
                                <img src="{{ Storage::url($product->image) }}" alt="Product Image" class="img-fluid rounded shadow-sm" style="max-width: 150px;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="row w-100">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="is_best_seller" id="is_best_seller" class="form-check-input" {{ $product->is_best_seller ? 'checked' : '' }}>
                                    <label for="is_best_seller" class="form-check-label">Best Seller</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="is_new_arrival" id="is_new_arrival" class="form-check-input" {{ $product->is_new_arrival ? 'checked' : '' }}>
                                    <label for="is_new_arrival" class="form-check-label">New Arrival</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="is_hot_sale" id="is_hot_sale" class="form-check-input" {{ $product->is_hot_sale ? 'checked' : '' }}>
                                    <label for="is_hot_sale" class="form-check-label">Hot Sale</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Product</button>
            </form>
        </div>
    </div>
@endsection
