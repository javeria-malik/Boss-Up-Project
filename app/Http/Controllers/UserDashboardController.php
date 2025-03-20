<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Fetch logged-in user's orders with related items and product details
        $orders = Order::where('user_id', Auth::id())->with('items.product')->get();

        return view('user.dashboard', compact('orders'));
    }
}
