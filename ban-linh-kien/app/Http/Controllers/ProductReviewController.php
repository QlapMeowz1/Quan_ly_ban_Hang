<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Product $product)
    {
        $user = auth()->user();
        $customer = $user->customer;

        // Kiểm tra đã mua hàng chưa
        $hasPurchased = $customer && $customer->orders()
            ->whereHas('orderItems', function($query) use ($product) {
                $query->where('product_id', $product->product_id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn cần mua sản phẩm này trước khi đánh giá.');
        }

        // Kiểm tra đã đánh giá chưa
        $hasReviewed = $product->reviews()
            ->where('customer_id', $customer->customer_id)
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:10|max:1000',
            'title' => 'nullable|string|max:200',
        ]);

        $product->reviews()->create([
            'customer_id' => $customer->customer_id,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'review_text' => $validated['review_text'],
            'status' => 'pending'
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn sẽ được kiểm duyệt trước khi hiển thị.');
    }
} 