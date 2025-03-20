@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Total Customers</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Information</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sr.No</th>
                            <th>User ID</th>
                            <th>Session ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Phone</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $srNo = 1; @endphp
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $order->user_id }}</td>
                            <td>{{ $order->session_id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->country }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $orders->links() }} <!-- Pagination -->
            </div>
        </div>
    </div>
</section>
@endsection
