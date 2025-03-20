@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Contact Messages</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Recieved at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{$message->created_at}}</td>
                            <td>
    <a href="{{ route('admin.contact.show', $message->id) }}" class="btn btn-dark btn-sm">View</a>
    <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-dark btn-sm">Delete</button>
    </form>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $messages->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
