<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;



class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure authentication
    }

    // Display the list of Products
   public function index(Request $request)
{
    if ($request->has('trash')) {
        $query = Product::onlyTrashed();
    } else {
        $query = Product::query();
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('price', 'LIKE', "%{$search}%");
    }

    if ($request->has('category_id') && !empty($request->category_id)) {
        // Get all child categories of the selected parent category
        $categoryIds = Category::where('parent_id', $request->category_id)->pluck('id')->toArray();
        $categoryIds[] = $request->category_id; // Include the selected parent category

        $query->whereIn('category_id', $categoryIds);
    }

    $products = $query->get();
    $categories = Category::all(); // ✅ Fetch categories

    return view('admin.product.index', compact('products', 'categories'));
}

        
    // Show the form for creating a new Product
    

public function create()
{
    $categories = Category::all();
    return view('admin.product.create', compact('categories'));
}

    // Handle file upload
    protected function handleFileUpload(Request $request, $existingImage = null)
{
    if ($request->hasFile('image')) {
        // Delete the existing image if it exists
        if ($existingImage && Storage::disk('public')->exists($existingImage)) {
            Storage::disk('public')->delete($existingImage);
        }

        $file = $request->file('image');
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                    . '_' . now()->format('Y-m-d_His')
                    . '.' . $file->getClientOriginalExtension();
        $imagePath = $file->storeAs('products', $filename, 'public');
        return $imagePath; // Store only the relative path (without '/storage/')
    }

    return $existingImage;
}



    // Store a newly created Product
    public function store(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:0,1', // ✅ Ensure status is required and valid
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Handle file upload
    $imagePath = $this->handleFileUpload($request);

    // Create the product
    $product = Product::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
        'quantity' => $request->input('quantity'),
        'category_id' => $request->input('category_id'),
        'is_best_seller' => $request->has('is_best_seller') ? 1 : 0,
        'is_new_arrival' => $request->has('is_new_arrival') ? 1 : 0,
        'is_hot_sale' => $request->has('is_hot_sale') ? 1 : 0,
        'slug' => Str::slug($request->input('title')),
        'image' => $imagePath,
        'status' => $request->input('status'), 
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully!');
}

    

    
    // Show the form for editing an existing Product
    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('admin.product.edit', compact('product'));
    }

    // Update the Product details
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();
        $imagePath = $this->handleFileUpload($request, $product->image);


        // Update the product details
        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => intval($request->input('quantity')),
            'is_best_seller' => $request->has('is_best_seller') ? 1 : 0,
            'is_new_arrival' => $request->has('is_new_arrival') ? 1 : 0,
            'is_hot_sale' => $request->has('is_hot_sale') ? 1 : 0,
            'image' => $imagePath,  
            'status' => $request->input('status'),

        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Soft delete a Product
    public function destroy($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();
    $product->delete(); // This will soft delete the product

    return redirect()->route('products.index')->with('success', 'Product moved to trash!');
}


    // Permanently delete a Product
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        
        // Delete product image from storage if exists
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        
        $product->forceDelete(); // Permanently delete from database
        return redirect()->route('products.with-trash')->with('success', 'Product permanently deleted.');
    }
    // Restore a soft deleted Product
    public function restore($id)
{
    $product = Product::withTrashed()->findOrFail($id);
    $product->restore();

    return redirect()->route('products.index')->with('success', 'Product restored successfully.');
}

public function toggleStatus($id)
{
    $product = Product::findOrFail($id);
    $product->status = !$product->status; // Toggle status
    $product->save();

    return redirect()->back()->with('success', 'Product status updated successfully.');
}


    // Display Products in trash
    public function withTrash()
    {
        $products = Product::onlyTrashed()->get();
        $categories = Category::all(); 
        return view('admin.product.index', compact('products','categories'));
    }
}
