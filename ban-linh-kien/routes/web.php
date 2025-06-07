<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Product & Category routes for public
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Cart routes
Route::get('/cart', function () {
    $cart = session('cart', []);
    $products = \App\Models\Product::whereIn('product_id', array_keys($cart))->get();
    return view('cart', compact('cart', 'products'));
})->name('cart.index');

Route::post('/cart/add', function (\Illuminate\Http\Request $request) {
    $cart = session('cart', []);
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1);

    if (isset($cart[$productId])) {
        $cart[$productId] += $quantity;
    } else {
        $cart[$productId] = $quantity;
    }
    session(['cart' => $cart]);
    return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
})->name('cart.add');

Route::post('/cart/remove', function (\Illuminate\Http\Request $request) {
    $cart = session('cart', []);
    $productId = $request->input('product_id');
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session(['cart' => $cart]);
    }
    return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
})->name('cart.remove');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/checkout', function () {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        $products = \App\Models\Product::whereIn('product_id', array_keys($cart))->get();
        return view('checkout', compact('cart', 'products'));
    })->name('checkout.index');

    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    

    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    

    Route::resource('admins', App\Http\Controllers\AdminController::class);
    

    Route::resource('products', App\Http\Controllers\ProductController::class);
    

    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    

    Route::resource('orders', App\Http\Controllers\OrderController::class);
    

    Route::resource('brands', App\Http\Controllers\BrandController::class);
    
  
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    
    
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/orders', [App\Http\Controllers\AdminController::class, 'userOrders'])->name('users.orders');
}); 