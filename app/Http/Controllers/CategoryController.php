<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

    public function index()
    {
        $categories = Category::with('children')->get(); // Fetch categories with subcategories if any
        return view('admin.categories.index', compact('categories'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $parentCategories = Category::whereNull('parent_id')->get();
    return view('admin.categories.create', compact('parentCategories'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    Category::create($request->all());

    return redirect()->route('categories.index')->with('success', 'Category created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
{
    $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
    return view('admin.categories.edit', compact('category', 'parentCategories'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    $category->update($request->all());

    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if the category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with subcategories.');
        }
    
        $category->delete();
    
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
    
}
