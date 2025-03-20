<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\OrderInvoiceMail;
use App\Models\Order; // Import the Order model

class OrderController extends Controller
{ 
    public function index()
    {
        $orders = Order::latest()->paginate(10); // Fetch orders with pagination
        return view('admin.order.order', compact('orders'));
    }

    public function order_detail(Order $order)
    {
         // Load order items along with products
         $order->load('items.product');
        return view('admin.order.orderdetail', compact('order'));
    }
    public function update(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->status = $request->input('status');
    $order->save();

    return redirect()->back()->with('success', 'Order status updated successfully.');
}
public function sendInvoiceEmail($orderId)
{
    $order = Order::findOrFail($orderId);
    
    // Ensure the user has an email
    if (!$order->user || !$order->user->email) {
        return redirect()->back()->with('error', 'Customer email not found!');
    }

    Mail::to($order->user->email)->send(new OrderInvoiceMail($order));

    return redirect()->back()->with('success', 'Invoice email sent successfully!');
}

}
