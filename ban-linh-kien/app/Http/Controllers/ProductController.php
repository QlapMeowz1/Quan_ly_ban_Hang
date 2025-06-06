<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Product::query();

        // Lọc theo hãng (brand)
        $brands = Brand::all();
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Lọc theo giá
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        // Lọc theo danh mục
        $categories = Category::all();
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo các thuộc tính specifications
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

        $products = $query->with(['category', 'images'])->paginate(20);

        // Lấy các giá trị duy nhất cho filter
        $chipsets = Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.chipset")) as chipset')
            ->distinct()->pluck('chipset')->filter();
        $ram_types = Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.ram_type")) as ram_type')
            ->distinct()->pluck('ram_type')->filter();
        $vga_series = Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.vga_series")) as vga_series')
            ->distinct()->pluck('vga_series')->filter();
        $cpu_series = Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.cpu_series")) as cpu_series')
            ->distinct()->pluck('cpu_series')->filter();
        $colors = Product::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(specifications, "$.color")) as color')
            ->distinct()->pluck('color')->filter();

        return view('products.index', compact(
            'products', 'brands', 'categories', 'chipsets', 'ram_types', 'vga_series', 'cpu_series', 'colors'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $product->product_id)
            ->take(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admins.products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|unique:products,product_code',
            'category_id' => 'required|exists:categories,category_id',
            'brand_id' => 'required|exists:brands,brand_id',
            'description' => 'nullable',
            'specifications' => 'nullable|json',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_url' => $path,
                    'is_primary' => $product->images()->count() === 0
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function edit(Product $product)
    {
        $product->load(['category', 'images']);
        $brands = Brand::all();
        $categories = Category::all();
        return view('admins.products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|unique:products,product_code,' . $product->product_id . ',product_id',
            'category_id' => 'required|exists:categories,category_id',
            'brand_id' => 'required|exists:brands,brand_id',
            'description' => 'nullable',
            'specifications' => 'nullable|json',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product->update($validated);

        // Xử lý ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_url' => $path,
                    'is_primary' => $product->images()->count() === 0
                ]);
            }
        }

        // Xử lý xóa ảnh
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    public function destroy(Product $product)
    {
        // Xóa các ảnh liên quan
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }
        $product->images()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công.');
    }
}
