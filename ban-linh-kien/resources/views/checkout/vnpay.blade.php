
@extends('layouts.web')

@section('title', 'Đang chuyển hướng thanh toán')

@push('styles')
<style>
    /* VNPay redirect page dark mode styles */
    .loading-container {
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .spinner {
        border: 4px solid #f3f4f6;
        border-top: 4px solid #dc2626;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .dark .loading-container {
        color: #f9fafb;
    }
    
    .dark .spinner {
        border-color: #4b5563;
        border-top-color: #dc2626;
    }
    
    /* Auto dark mode detection */
    @media (prefers-color-scheme: dark) {
        .loading-container {
            color: #f9fafb;
        }
        
        .spinner {
            border-color: #4b5563;
            border-top-color: #dc2626;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="loading-container text-center">
        <div class="spinner"></div>
        <h3 class="mb-3">Đang chuyển hướng đến VNPay...</h3>
        <p class="text-muted">Vui lòng chờ trong giây lát. Bạn sẽ được chuyển hướng tự động.</p>
        <div class="mt-4">
            <small class="text-muted">Nếu không được chuyển hướng tự động, 
                <a href="{{ route('checkout.index') }}" class="text-decoration-none">nhấn vào đây</a>
            </small>
        </div>
    </div>
</div>

<script>
    // Redirect after a short delay for better UX
    setTimeout(function() {
        window.location.href = "{{ route('checkout.index') }}";
    }, 5000);
</script>
@endsection