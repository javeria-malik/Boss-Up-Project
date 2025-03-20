@extends('admin.layout.master')

@section('content')
<div class="container-fluid my-2">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Order: OR-{{ $order->id }}</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('order') }}" class="btn btn-primary">Back</a>
        </div>
    </div> 
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Shipping Address</h1>
                                <address>
                                    <strong>{{ $order->name }}</strong><br>
                                    {{ $order->shipping_address }}<br>
                                    Phone: {{ $order->phone }}<br>
                                    Email: {{ $order->user->email }}
                                </address>
                            </div>
                            
                            <div class="col-sm-4 invoice-col">
                                <b>Order ID:</b> {{ $order->id }}<br>
                                <b>Total:</b> ${{ number_format($order->total_price, 2) }}<br>
                                <b>Status:</b> <span class="text-success">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>
                                    <th width="100">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->title }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>$5.00</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>${{ number_format($order->total_price + 5, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Order Status</h2>
                        <form action="{{ route('order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
    <div class="card-body">
        <h2 class="h4 mb-3">Send Invoice Email</h2>
        <form action="{{ route('order.sendInvoice', $order->id) }}" method="GET">
            <button type="submit" class="btn btn-primary">Send Invoice</button>
        </form>
    </div>
</div>

            </div>
        </div>
    </div>  
</section>
@endsection
