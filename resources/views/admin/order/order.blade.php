@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <div class="input-group" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">                                
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Orders ID</th>                                            
                        <th>Customer</th>
                        <th>Contact</th> 
                        <th>Total Amount</th>
                        <th>Date Purchased</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><a href="{{ route('order.detail', $order->id) }}">OR-{{ $order->id }}</a></td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-dark w-100 text-center p-2">{{ ucfirst($order->status) }}</span> 
                            </td>
                            <td>
                                <a href="{{ route('order.detail', $order->id) }}" class="btn btn-dark btn-sm btn-block">View</a> 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>                                        
        </div>
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                {{ $orders->links('pagination::bootstrap-4') }}
            </ul>
        </div>
    </div>
</div>
@endsection
