<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch products that belong to at least one category (best-seller, new-arrival, hot-sale)
        $products = Product::where('status', 1)
                            ->where(function ($query) {
                                $query->where('is_best_seller', 1)
                                      ->orWhere('is_new_arrival', 1)
                                      ->orWhere('is_hot_sale', 1);
                            })
                            ->get();

        return view('home.home', compact('products'));
    }
    public function shop(Request $request)
{
    $query = Product::query();

    // Category Filter
    if ($request->has('category') && !empty($request->category)) {
        $query->where('category_id', $request->category);
    }

    // Price Filter
    if ($request->has('min_price') && $request->has('max_price')) {
        $query->whereBetween('price', [$request->min_price, $request->max_price]);
    }

    // Sorting
    if ($request->has('sort')) {
        $sortOrder = $request->sort == 'asc' ? 'asc' : 'desc';
        $query->orderBy('price', $sortOrder);
    }

    $products = $query->paginate(9);
    $categories = Category::all(); // Ensure categories are loaded
    $priceRanges = [
        ['min' => 0, 'max' => 50],
        ['min' => 50, 'max' => 100],
        ['min' => 100, 'max' => 200],
        ['min' => 200, 'max' => 500],
    ];

    return view('home.shop.shoppage', compact('products', 'categories', 'priceRanges'));
}

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('status', 1)
        ->where('id', '>', $product->id)
        ->orderBy('id', 'asc')
        ->take(4)
        ->get();
        return view('home.shop.shopdetails', compact('product','relatedProducts'));
    }
    public function shoppingcart(){
        return view('home.shop.shoppingcart');
    }
    public function about(){
        return view('home.about');
    }
    public function contact(){
        return view('home.contact');
    }

    
    
   }
