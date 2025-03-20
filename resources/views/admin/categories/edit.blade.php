@extends('admin.layout.master')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">None</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
