<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('home');
});

Route::resource('admins', AdminController::class);
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

Route::get('/cart', function () {
    $cart = session('cart', []);
    return view('cart', compact('cart'));
});

Route::post('/cart', function (\Illuminate\Http\Request $request) {
    $cart = session('cart', []);
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1);

    if (isset($cart[$productId])) {
        $cart[$productId] += $quantity;
    } else {
        $cart[$productId] = $quantity;
    }
    session(['cart' => $cart]);
    return redirect('/cart')->with('success', 'Đã thêm vào giỏ hàng!');
});

Route::post('/cart/remove', function (\Illuminate\Http\Request $request) {
    $cart = session('cart', []);
    $productId = $request->input('product_id');
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session(['cart' => $cart]);
    }
    return redirect('/cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Auth::routes();

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{id}/orders', [App\Http\Controllers\AdminController::class, 'userOrders'])->name('admin.user.orders');
});

// Hiển thị form checkout
Route::get('/checkout', function () {
    $cart = session('cart', []);
    return view('checkout', compact('cart'));
})->middleware('auth');

// Xử lý đặt hàng
Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->middleware('auth')->name('checkout.store');
