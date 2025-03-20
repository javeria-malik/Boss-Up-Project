@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Total Orders</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer-Orders</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Created At</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user_id }}</td>
                            
                            <td>{{ $order->name }}</td>
                        
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
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
