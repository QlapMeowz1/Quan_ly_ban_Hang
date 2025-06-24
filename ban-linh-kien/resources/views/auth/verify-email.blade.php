@extends('layouts.app')

@section('title', 'Xác Thực Email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-envelope-check"></i> Xác Thực Email</h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Info Text -->
                    <div class="text-center mb-4">
                        <i class="fas fa-user-check fa-3x text-primary mb-3"></i>
                        <h5>Xác thực email của bạn</h5>
                        <p class="text-muted">
                            Chúng tôi đã gửi mã OTP đến email: <strong>{{ $customer->email }}</strong>
                        </p>
                        <p class="text-muted">
                            Vui lòng kiểm tra hộp thư và nhập mã OTP để hoàn tất đăng ký.
                        </p>
                    </div>

                    <!-- OTP Verification Form -->
                    <form method="POST" action="{{ route('email.verify') }}" id="otpForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ $customer->email }}">
                        
                        <div class="mb-3">
                            <label for="otp" class="form-label">
                                <i class="fas fa-key"></i> Mã OTP (6 số)
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                                   id="otp" 
                                   name="otp" 
                                   placeholder="000000"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required
                                   autofocus>
                            <div class="form-text">Nhập 6 chữ số nhận được qua email</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check"></i> Xác Thực
                            </button>
                        </div>
                    </form>

                    <!-- Resend OTP -->
                    <div class="text-center mt-4">
                        <p class="mb-2">Không nhận được mã OTP?</p>
                        
                        <form method="POST" action="{{ route('email.resend') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ $customer->email }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm" id="resendBtn">
                                <i class="fas fa-redo"></i> Gửi lại mã OTP
                            </button>
                        </form>
                        
                        <div class="mt-2">
                            <small class="text-muted">
                                Mã OTP có hiệu lực trong <strong>10 phút</strong>
                            </small>
                        </div>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <a href="{{ route('login') }}" class="btn btn-link">
                            <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format OTP input
    const otpInput = document.getElementById('otp');
    
    otpInput.addEventListener('input', function(e) {
        // Only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Auto-submit when 6 digits entered
        if (this.value.length === 6) {
            document.getElementById('otpForm').submit();
        }
    });

    // Prevent resend button spam
    const resendBtn = document.getElementById('resendBtn');
    let resendTimeout;
    
    resendBtn.addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
        
        // Re-enable after 60 seconds
        resendTimeout = setTimeout(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-redo"></i> Gửi lại mã OTP';
        }, 60000);
    });
});
</script>
@endsection 