<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    // Show the cart
    public function index()
    {
        $cart = session()->get('cart', []);

        // Ensure price key exists before calculation
        $subtotal = array_sum(array_map(function ($item) {
            return (isset($item['price']) ? $item['price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 1);
        }, $cart));

        $total = $subtotal; // Add taxes or discounts if needed

        return view('home.shop.shoppingcart', compact('cart', 'subtotal', 'total'));
    }

    // Add product to cart and create session ID
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        // Generate a session ID if it doesn't exist
        if (!session()->has('session_id')) {
            session()->put('session_id', uniqid('session_', true));
        }

        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

        // Add or update the product in the cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->title ?? 'Unnamed Product', // Ensure this field exists in DB
                'price' => $product->price ?? 0, // Ensure price exists
                'quantity' => $request->quantity ?? 1,
                'image' => $product->image ?? 'default-product.jpg', // Default image
            ];
        }

        // Save the cart in the session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Update cart item quantity
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$request->product_id])) { // Use product_id instead of id
            // Update quantity
            $cart[$request->product_id]['quantity'] = $request->quantity;
    
            // Update total price of item
            $cart[$request->product_id]['total_price'] = $cart[$request->product_id]['price'] * $request->quantity;
        }
    
        // Update session with new cart
        session()->put('cart', $cart);
    
        // Recalculate total amount
        $cartTotal = array_sum(array_column($cart, 'total_price' ?? 0));
        session()->put('cart_total', $cartTotal);
    
       
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    



    // Remove product from cart
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    // Clear entire cart
    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('session_id');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    // Checkout process
    public function checkout()
{
    if (!Auth::check()) {
        session()->put('checkout_redirect', true); // Store checkout redirection intent
        return redirect()->route('login')->with('error', 'You need to log in first to proceed to checkout.');
    }

    // Ensure user has a session ID
    if (!session()->has('session_id')) {
        session()->put('session_id', uniqid('session_', true));
    }

    return view('home.shop.checkout');
}

    public function placeOrder(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'address' => 'required|string',
        'phone' => 'required|string|max:15',
    ]);

    $session_id = session()->get('session_id') ?? uniqid('session_', true);
    session()->put('session_id', $session_id);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
    }

    // Create a new order
    $order = new Order();
    $order->user_id = Auth::id();
    $order->session_id = $session_id;
    $order->name = $request->first_name . ' ' . $request->last_name;
    $order->country = $request->country;
    $order->address = $request->address;
    $order->phone = $request->phone;
    $order->total_price = array_sum(array_map(function ($item) {
        return (isset($item['price']) ? $item['price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 1);
    }, $cart));
    $order->status = 'pending';
    $order->save();

    // Insert items into order_items table
    foreach ($cart as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'] ?? 0,
            'quantity' => $item['quantity'] ?? 1,
            'price' => $item['price'] ?? 0,
        ]);
    }

    // Clear the cart after placing the order
    session()->forget('cart');
    session()->forget('session_id');

    
    return redirect()->route('checkout')->with('success', 'Order placed successfully! You have been logged out.');
}


public function getCartTotal()
{
    if (!Auth::check()) {
        return response()->json(['total' => 0, 'items' => 0]); 
    }

    $cart = session()->get('cart', []);

    $subtotal = array_sum(array_map(function ($item) {
        return (isset($item['price']) ? $item['price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 1);
    }, $cart));

    return response()->json(['total' => number_format($subtotal, 2), 'items' => count($cart)]);
}

}
