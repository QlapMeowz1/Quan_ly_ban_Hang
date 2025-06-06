<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $brands = Brand::all();
        return view('admins.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admins.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|max:255',
            'brand_description' => 'nullable',
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('brand_logo')) {
            $path = $request->file('brand_logo')->store('brands', 'public');
            $validated['brand_logo'] = $path;
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được tạo thành công.');
    }

    public function show(Brand $brand)
    {
        return view('admins.brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('admins.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'brand_name' => 'required|max:255',
            'brand_description' => 'nullable',
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('brand_logo')) {
            // Xóa logo cũ nếu có
            if ($brand->brand_logo) {
                Storage::disk('public')->delete($brand->brand_logo);
            }
            
            $path = $request->file('brand_logo')->store('brands', 'public');
            $validated['brand_logo'] = $path;
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được cập nhật thành công.');
    }

    public function destroy(Brand $brand)
    {
        // Xóa logo trước khi xóa brand
        if ($brand->brand_logo) {
            Storage::disk('public')->delete($brand->brand_logo);
        }

        $brand->delete();
        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được xóa thành công.');
    }
} 