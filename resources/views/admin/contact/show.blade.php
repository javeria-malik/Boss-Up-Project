@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Message Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $message->name }}</p>
            <p><strong>Email:</strong> {{ $message->email }}</p>
            <p><strong>Message:</strong> {{ $message->message }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.contact') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
