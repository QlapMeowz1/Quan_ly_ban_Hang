@extends('layouts.web')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-shield-alt"></i> Xác thực Email</h4>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                        <h5>Kiểm tra email của bạn</h5>
                        <p class="text-muted">
                            Chúng tôi đã gửi mã OTP 6 chữ số đến email: <br>
                            <strong>{{ $customer->email }}</strong>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('verification.verify') }}" id="verifyForm">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="otp" class="form-label">Mã OTP *</label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                                   id="otp" 
                                   name="otp" 
                                   placeholder="000000" 
                                   maxlength="6" 
                                   autocomplete="off"
                                   style="letter-spacing: 0.5em; font-weight: bold; font-size: 1.5rem;"
                                   required>
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-clock"></i> Mã OTP có hiệu lực trong 10 phút
                            </small>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="verifyBtn">
                                <i class="fas fa-check"></i> Xác thực
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="mb-2">Không nhận được email?</p>
                        <button type="button" class="btn btn-outline-secondary" id="resendBtn">
                            <i class="fas fa-redo"></i> Gửi lại mã OTP
                        </button>
                        <div id="resendTimer" class="text-muted mt-2" style="display: none;">
                            <small>Vui lòng đợi <span id="countdown">120</span>s trước khi gửi lại</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Lưu ý:</strong> Vui lòng kiểm tra thư mục spam nếu không tìm thấy email xác thực.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus vào ô input OTP
    document.getElementById('otp').focus();

    // Chỉ cho phép nhập số
    document.getElementById('otp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length >= 6) {
            // Tự động submit khi nhập đủ 6 số
            document.getElementById('verifyForm').submit();
        }
    });

    // Xử lý nút gửi lại OTP
    let resendBtn = document.getElementById('resendBtn');
    let resendTimer = document.getElementById('resendTimer');
    let countdown = document.getElementById('countdown');
    let timeLeft = 0;
    let countdownInterval;

    function startCountdown(seconds) {
        timeLeft = seconds;
        resendBtn.disabled = true;
        resendTimer.style.display = 'block';
        
        countdownInterval = setInterval(function() {
            timeLeft--;
            countdown.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                resendBtn.disabled = false;
                resendTimer.style.display = 'none';
            }
        }, 1000);
    }

    resendBtn.addEventListener('click', function() {
        fetch('{{ route("verification.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                startCountdown(120); // 2 phút
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Có lỗi xảy ra khi gửi lại OTP!');
        });
    });

    // Kiểm tra nếu có timer từ trước
    @if($customer->email_otp_expires_at && \Carbon\Carbon::parse($customer->email_otp_expires_at)->isFuture())
        let remainingTime = {{ \Carbon\Carbon::parse($customer->email_otp_expires_at)->diffInSeconds(\Carbon\Carbon::now()) }};
        if (remainingTime > 480) { // Còn hơn 8 phút
            startCountdown(600 - remainingTime); // 10 phút - thời gian đã trôi qua
        }
    @endif
});
</script>
@endsection 