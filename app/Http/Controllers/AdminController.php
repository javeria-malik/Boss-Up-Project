<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order; 
use App\Models\Product;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function index()
{
    if (Auth::check()) { // Ensure user is authenticated
        $usertype = Auth::user()->usertype; 

        if ($usertype == 'admin') {
            $totalOrders = Order::count(); // Total orders based on the highest ID
            $totalCustomers = Order::distinct('name')->count('name'); // Unique customers
            $totalSales = Order::sum('total_price'); // Sum of total_price column
            $pendingOrders = Order::where('status', 'pending')->count();
            $deliveredOrders = Order::where('status', 'delivered')->count();
            $shippedOrders = Order::where('status', 'shipped')->count();
            $cancelledOrders = Order::where('status', 'cancelled')->count();

           
            return view('admin.dashboard', compact('totalOrders', 'totalCustomers', 'totalSales','pendingOrders', 'deliveredOrders', 'shippedOrders','cancelledOrders')); 
        
            
        
            
        } elseif ($usertype == 'user') {
            // Check if the user was redirected from checkout
            if (session()->pull('checkout_redirect', false)) { 
                return redirect()->route('checkout'); // Redirect to checkout after login
            }
            return redirect()->route('user.dashboard'); // Redirect to user dashboard
        } else {
            Auth::logout(); // Logout if usertype is unknown
            return redirect()->route('login')->withErrors([
                'error' => 'Unauthorized access. Please log in again.',
            ]);
        }
    } else {
        return redirect()->route('login')->withErrors([
            'error' => 'Please log in to continue.',
        ]);
    }
}
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
    public function userDashboard()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->withErrors(['error' => 'User not authenticated.']);
    }

    // Load orders with related items and products
    $orders = $user->orders()->with('items.product')->orderBy('created_at', 'desc')->get();

    // Pass the data to the view
    return view('user.dashboard', compact('orders'));
}
public function totalOrders()
{
    $orders = Order::orderBy('id', 'desc')->paginate(10); // Fetch orders with pagination
    return view('admin.AdminDashboard.total_orders', compact('orders'));
}
public function totalCustomers()
{
    $orders = Order::orderBy('id', 'desc')->paginate(10); // Fetch orders with pagination
    return view('admin.AdminDashboard.total_customers', compact('orders'));
}
}
