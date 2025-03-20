@extends('admin.layout.master')

@section('content')
<div class="container">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>

    <ul class="list-group mt-3">
        @foreach($categories as $category) 
            <li class="list-group-item">
                <strong>{{ $category->name }}</strong> ({{ $category->description }})
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>

                @if($category->children->count())
                    <ul class="list-group mt-2">
                        @foreach($category->children as $child)
                            <li class="list-group-item">
                                - {{ $child->name }} ({{ $child->description }})
                                <a href="{{ route('categories.edit', $child->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $child->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
