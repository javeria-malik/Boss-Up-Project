@extends('admin.layout.master')

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

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Total Orders -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.orders') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Total Customers -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $totalCustomers }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.customer') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!-- Pending Orders -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $pendingOrders }}</h3>
                        <p>Pending Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                    <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $deliveredOrders }}</h3>
                        <p>Delivered Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark-circle"></i>
                    </div>
                    <a href="{{ route('admin.orders', ['status' => 'delivered']) }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Shipped Orders -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $shippedOrders }}</h3>
                        <p>Shipped Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-send"></i>
                    </div>
                    <a href="{{ route('admin.orders', ['status' => 'shipped']) }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
             <!-- Shipped Orders -->
             <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $cancelledOrders }}</h3>
                        <p>Cancelled Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-send"></i>
                    </div>
                    <a href="{{ route('admin.orders', ['status' => 'cancelled']) }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

           

            <!-- Total Sales -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>${{ number_format($totalSales, 2) }}</h3>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                </div>
            </div>
        </div>
    </div>					
</section>
@endsection
