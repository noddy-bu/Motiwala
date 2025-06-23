<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS (5.3) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your other CSS (app-modern.min.css, icons.min.css, etc.) -->
    <link href="/assets/backend/css/app-modern.min.css" rel="stylesheet" />
    <link href="/assets/backend/css/icons.min.css" rel="stylesheet" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <div class="auth-fluid-form-box" style="width: 350px;">
            <div class="card-body d-flex flex-column h-100">
                <!-- Logo (reuse from login) -->
                <div class="auth-brand text-center text-lg-start mb-4">
                    <a href="/" class="logo-dark text-center">
                        <img src="{{ asset('/assets/frontend/images/logo.png') }}" alt="dark logo" style="width:42%;">
                    </a>
                </div>

                <div class="my-auto">
                    <h4 class="mb-3">Verify OTP</h4>
                    <p class="text-muted mb-4">
                        We sent a 6‐digit code to <strong>{{ Session::get('otp_phone') }}</strong>.
                        Please enter it below.
                    </p>

                    {{-- Show any errors or success messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- OTP Verification form -->
                    <form method="POST" action="{{ route('backend.login.phone.verify') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input class="form-control" type="text" id="otp" name="otp" required maxlength="6"
                                placeholder="6-digit code">
                        </div>

                        <div class="d-grid mb-3 text-center">
                            <button class="btn btn-primary" type="submit">
                                Verify &amp; Sign In
                            </button>
                        </div>
                    </form>

                    <!-- ==== Resend OTP Form ==== -->
                    <form method="POST" action="{{ route('backend.login.phone.resend') }}" id="resendForm">
                        @csrf
                        <div class="text-center">
                            <button
                                class="btn btn-link p-0"
                                type="submit"
                                id="btnResend"
                            >
                                Resend OTP
                            </button>
                            <span id="countdown" class="text-muted ms-2"></span>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <footer class="footer footer-alt mt-auto">
                    <p class="text-muted">
                        <a href="{{ route('backend.login') }}" class="text-muted"><b>Back to Login</b></a>
                    </p>
                </footer>
            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth right image -->
        <div class="auth-fluid-right text-center" style="background-image:url('/assets/frontend/images/calculator_images.JPG');
                background-size: cover;
                background-position: center center;">
            {{-- blank or testimonial --}}
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid -->

    <!-- JS at bottom -->
    <script src="/assets/backend/js/vendor.min.js"></script>
    <script src="/assets/backend/js/app.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ===== Frontend countdown logic ===== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // The number of seconds user must wait (passed from controller)
            let secondsRemaining = {{ $secondsRemaining ?? 0 }};

            // Reference to the “Resend OTP” button and countdown <span>
            const btnResend = document.getElementById('btnResend');
            const countdownSpan = document.getElementById('countdown');

            // If there are already seconds left, disable the button initially
            if (secondsRemaining > 0) {
                disableAndCountdown(secondsRemaining);
            }

            function disableAndCountdown(sec) {
                // Disable the button
                btnResend.disabled = true;
                btnResend.classList.add('text-muted');
                btnResend.style.pointerEvents = 'none';

                // Update the countdown text immediately
                updateCountdownText(sec);

                // Each second, decrease sec and update text
                const interval = setInterval(() => {
                    sec--;
                    if (sec <= 0) {
                        clearInterval(interval);
                        btnResend.disabled = false;
                        btnResend.classList.remove('text-muted');
                        btnResend.style.pointerEvents = 'auto';
                        countdownSpan.innerText = ''; // clear “mm:ss”
                    } else {
                        updateCountdownText(sec);
                    }
                }, 1000);
            }

            function updateCountdownText(sec) {
                // Format mm:ss
                const minutes = Math.floor(sec / 60);
                const seconds = sec % 60;
                const mm = String(minutes).padStart(2, '0');
                const ss = String(seconds).padStart(2, '0');
                countdownSpan.innerText = `${mm}:${ss}`;
            }
        });
    </script>
</body>

</html>