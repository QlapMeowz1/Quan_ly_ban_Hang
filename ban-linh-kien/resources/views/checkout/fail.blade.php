@extends('layouts.web')

@section('title', 'Thanh toán thất bại')

@push('styles')
<style>
    /* Fail page dark mode styles */
    .dark .bg-white {
        background-color: #374151 !important;
        color: #f9fafb !important;
    }
    
    .dark .text-gray-900 {
        color: #f9fafb !important;
    }
    
    .dark .text-gray-600 {
        color: #d1d5db !important;
    }
    
    .dark .text-gray-700 {
        color: #e5e7eb !important;
    }
    
    .dark .text-gray-500 {
        color: #9ca3af !important;
    }
    
    .dark .bg-red-100 {
        background-color: #7f1d1d !important;
    }
    
    .dark .text-red-600 {
        color: #f87171 !important;
    }
    
    .dark .border-gray-300 {
        border-color: #6b7280 !important;
    }
    
    /* Auto dark mode detection */
    @media (prefers-color-scheme: dark) {
        .bg-white {
            background-color: #374151 !important;
            color: #f9fafb !important;
        }
        
        .text-gray-900 {
            color: #f9fafb !important;
        }
        
        .text-gray-600 {
            color: #d1d5db !important;
        }
        
        .text-gray-700 {
            color: #e5e7eb !important;
        }
        
        .text-gray-500 {
            color: #9ca3af !important;
        }
        
        .bg-red-100 {
            background-color: #7f1d1d !important;
        }
        
        .text-red-600 {
            color: #f87171 !important;
        }
        
        .border-gray-300 {
            border-color: #6b7280 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Thanh toán thất bại</h1>
        
        @if(session('message'))
            <p class="text-gray-600 mb-8">{{ session('message') }}</p>
        @else
            <p class="text-gray-600 mb-8">Đã xảy ra lỗi trong quá trình thanh toán. Vui lòng thử lại.</p>
        @endif
        
        <div class="space-y-4">
            <a href="{{ route('checkout.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                Thử lại thanh toán
            </a>
            <br>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                Về trang chủ
            </a>
        </div>
        
        <div class="mt-8 text-sm text-gray-500">
            <p>Cần hỗ trợ? Liên hệ với chúng tôi:</p>
            <p><strong>Hotline:</strong> 1900-1234 | <strong>Email:</strong> support@linhkien.com</p>
        </div>
    </div>
</div>
@endsection 