<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Product::query();

        // Lọc theo hãng (brand)
        $brands = \App\Models\Brand::all();
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Lọc theo giá
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        // Lọc theo danh mục
        $categories = \App\Models\Category::all();
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo các thuộc tính specifications (ví dụ: chipset, ram_type, vga_series, cpu_series, color)
        if ($request->filled('chipset')) {
            $query->where('specifications->chipset', $request->chipset);
        }
        if ($request->filled('ram_type')) {
            $query->where('specifications->ram_type', $request->ram_type);
        }
        if ($request->filled('vga_series')) {
            $query->where('specifications->vga_series', $request->vga_series);
        }
        if ($request->filled('cpu_series')) {
            $query->where('specifications->cpu_series', $request->cpu_series);
        }
        if ($request->filled('color')) {
            $query->where('specifications->color', $request->color);
        }

        // Sắp xếp
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') $query->orderBy('price');
            elseif ($request->sort == 'price_desc') $query->orderByDesc('price');
            elseif ($request->sort == 'newest') $query->orderByDesc('created_at');
            else $query->orderByDesc('featured');
        } else {
            $query->orderByDesc('featured');
        }

        $products = $query->paginate(20);

        // Lấy các giá trị duy nhất cho filter (ví dụ: chipset, ram_type...)
        $chipsets = \App\Models\Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.chipset")) as chipset')->distinct()->pluck('chipset')->filter();
        $ram_types = \App\Models\Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.ram_type")) as ram_type')->distinct()->pluck('ram_type')->filter();
        $vga_series = \App\Models\Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.vga_series")) as vga_series')->distinct()->pluck('vga_series')->filter();
        $cpu_series = \App\Models\Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.cpu_series")) as cpu_series')->distinct()->pluck('cpu_series')->filter();
        $colors = \App\Models\Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.color")) as color')->distinct()->pluck('color')->filter();

        return view('products.index', compact(
            'products', 'brands', 'categories', 'chipsets', 'ram_types', 'vga_series', 'cpu_series', 'colors'
        ));
    }

    public function show($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    //
}
