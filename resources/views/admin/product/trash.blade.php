@extends('layout.master')

@section('content')
    <div class="container">
        <h1>Trash</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->description }}</td>
                        <td>
                            <form action="{{ route('posts.restore', $post->slug) }}" method="GET" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Restore</button>
                            </form>
                            <form action="{{ route('posts.forceDelete', $post->slug) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Permanently</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
