<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $customer = $user->customer;

        // Nếu không có customer hoặc email chưa được xác thực
        if (!$customer || !$customer->email_verified) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Vui lòng xác thực email trước khi tiếp tục.'], 403);
            }
            return redirect()->route('verification.form')->with('error', 'Vui lòng xác thực email trước khi tiếp tục.');
        }

        return $next($request);
    }
} 