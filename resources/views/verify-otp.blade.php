<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Culturoo</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #dc2626 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .verification-container {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .verification-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f97316, #ea580c, #dc2626);
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #f97316;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .description {
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .email-display {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 12px 16px;
            color: #f97316;
            font-weight: 600;
            margin-bottom: 2rem;
            border: 2px solid #fed7aa;
        }

        .otp-form {
            margin-bottom: 2rem;
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            background: #fafafa;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            outline: none;
            border-color: #f97316;
            background: white;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        .otp-input.filled {
            border-color: #f97316;
            background: #fff7ed;
        }

        .verify-btn {
            width: 100%;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .verify-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #ea580c, #dc2626);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
        }

        .verify-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .resend-section {
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .resend-text {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .resend-btn {
            background: none;
            border: none;
            color: #f97316;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .resend-btn:hover:not(:disabled) {
            color: #ea580c;
        }

        .resend-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .timer {
            color: #6b7280;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .success-message {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 640px) {
            .verification-container {
                padding: 2rem 1.5rem;
                margin: 10px;
            }

            .otp-input {
                width: 45px;
                height: 45px;
                font-size: 16px;
            }

            .otp-input-container {
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    
    <div class="verification-container">
        <div class="logo">Culturoo</div>
        <h1 class="title">Verify Your Email</h1>
        <p class="description">
            We've sent a 6-digit verification code to your email address. Please enter it below to complete your registration.
        </p>
        
        <div class="email-display">{{ $email }}</div>

        <div id="errorMessage" class="error-message" style="display: none;"></div>
        <div id="successMessage" class="success-message" style="display: none;"></div>

        <form id="otpForm" class="otp-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="otp-input-container">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" autocomplete="off">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" autocomplete="off">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" autocomplete="off">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" autocomplete="off">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" autocomplete="off">
                <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" autocomplete="off">
            </div>

            <button type="submit" id="verifyBtn" class="verify-btn">
                <span id="verifyBtnText">Verify Email</span>
                <span id="verifyBtnLoader" class="loading" style="display: none;"></span>
            </button>
        </form>

        <div class="resend-section">
            <p class="resend-text">Didn't receive the code?</p>
            <button id="resendBtn" class="resend-btn">Resend Code</button>
            <div id="resendTimer" class="timer" style="display: none;">
                Resend available in <span id="countdown">60</span> seconds
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const verifyBtn = document.getElementById('verifyBtn');
            const verifyBtnText = document.getElementById('verifyBtnText');
            const verifyBtnLoader = document.getElementById('verifyBtnLoader');
            const resendBtn = document.getElementById('resendBtn');
            const resendTimer = document.getElementById('resendTimer');
            const countdown = document.getElementById('countdown');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');
            const otpForm = document.getElementById('otpForm');

            let resendCountdown = 0;
            let resendInterval;

            // Auto-focus first input
            otpInputs[0].focus();

            // Handle OTP input navigation
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    if (this.value) {
                        this.classList.add('filled');
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else {
                        this.classList.remove('filled');
                    }

                    checkFormValidity();
                });

                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].classList.remove('filled');
                    }

                    // Handle paste
                    if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                        e.preventDefault();
                        navigator.clipboard.readText().then(text => {
                            const digits = text.replace(/[^0-9]/g, '').substring(0, 6);
                            digits.split('').forEach((digit, i) => {
                                if (otpInputs[i]) {
                                    otpInputs[i].value = digit;
                                    otpInputs[i].classList.add('filled');
                                }
                            });
                            checkFormValidity();
                        });
                    }
                });
            });

            function checkFormValidity() {
                const code = Array.from(otpInputs).map(input => input.value).join('');
                verifyBtn.disabled = code.length !== 6;
            }

            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
            }

            function showSuccess(message) {
                successMessage.textContent = message;
                successMessage.style.display = 'block';
                errorMessage.style.display = 'none';
            }

            function hideMessages() {
                errorMessage.style.display = 'none';
                successMessage.style.display = 'none';
            }

            function setLoading(loading) {
                if (loading) {
                    verifyBtnText.style.display = 'none';
                    verifyBtnLoader.style.display = 'inline-block';
                    verifyBtn.disabled = true;
                } else {
                    verifyBtnText.style.display = 'inline-block';
                    verifyBtnLoader.style.display = 'none';
                    checkFormValidity();
                }
            }

            function startResendCountdown() {
                resendCountdown = 60;
                resendBtn.style.display = 'none';
                resendTimer.style.display = 'block';
                
                resendInterval = setInterval(() => {
                    resendCountdown--;
                    countdown.textContent = resendCountdown;
                    
                    if (resendCountdown <= 0) {
                        clearInterval(resendInterval);
                        resendBtn.style.display = 'inline-block';
                        resendTimer.style.display = 'none';
                    }
                }, 1000);
            }

            // Handle form submission
            otpForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const code = Array.from(otpInputs).map(input => input.value).join('');
                if (code.length !== 6) return;

                setLoading(true);
                hideMessages();

                fetch('{{ route("auth.verify-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: '{{ $email }}',
                        otp_code: code
                    })
                })
                .then(response => response.json())
                .then(data => {
                    setLoading(false);
                    
                    if (data.success) {
                        showSuccess('Email verified successfully! Redirecting...');
                        setTimeout(() => {
                            window.location.href = data.redirect || '{{ route("profile") }}';
                        }, 1500);
                    } else {
                        showError(data.message || 'Invalid verification code. Please try again.');
                        // Clear inputs
                        otpInputs.forEach(input => {
                            input.value = '';
                            input.classList.remove('filled');
                        });
                        otpInputs[0].focus();
                    }
                })
                .catch(error => {
                    setLoading(false);
                    showError('Something went wrong. Please try again.');
                    console.error('Error:', error);
                });
            });

            // Handle resend code
            resendBtn.addEventListener('click', function() {
                resendBtn.disabled = true;
                hideMessages();

                fetch('{{ route("auth.resend-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: '{{ $email }}'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('A new verification code has been sent to your email.');
                        startResendCountdown();
                    } else {
                        showError(data.message || 'Failed to resend code. Please try again.');
                    }
                    resendBtn.disabled = false;
                })
                .catch(error => {
                    showError('Something went wrong. Please try again.');
                    resendBtn.disabled = false;
                    console.error('Error:', error);
                });
            });

            // Start initial resend countdown
            startResendCountdown();
        });
    </script>
</body>
</html>
