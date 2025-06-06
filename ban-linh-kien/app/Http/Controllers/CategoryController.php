<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->category_id)
            ->with(['category', 'images'])
            ->paginate(20);
            
        return view('categories.show', compact('category', 'products'));
    }
}
