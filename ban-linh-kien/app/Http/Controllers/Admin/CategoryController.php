<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $categories = Category::with('parent')->paginate(20);
        return view('admins.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admins.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|max:255',
            'category_description' => 'nullable',
            'parent_category_id' => 'nullable|exists:categories,category_id',
        ]);
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục thành công!');
    }

    public function show(Category $category)
    {
        $category->load('parent', 'products');
        return view('admins.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = Category::where('category_id', '!=', $category->category_id)->get();
        return view('admins.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => 'required|max:255',
            'category_description' => 'nullable',
            'parent_category_id' => 'nullable|exists:categories,category_id',
        ]);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục!');
    }
} 