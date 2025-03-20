@extends('user.layout.master_user')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container">
        <h2>Your Orders</h2>
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Order ID-</strong> {{ $order->id }} | 
                    <strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }} | 
                    <strong>Status:</strong> {{ ucfirst($order->status) }}
					 
                </div>
                <div class="card-body">
                    <h5>Items:</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
								<th>Purchase Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
									<td>{{ $item->product->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
