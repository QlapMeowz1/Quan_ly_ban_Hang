<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $products = $category->products ?? [];
        return view('categories.show', compact('category', 'products'));
    }
}
