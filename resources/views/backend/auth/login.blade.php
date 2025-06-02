<!DOCTYPE html>
<html lang="en" data-layout-mode="detached" data-topbar-color="dark" data-menu-color="light" data-sidenav-user="true">

<head>
    <meta name="robots" content="noindex">
    <meta charset="utf-8" />
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme Config Js -->
    <script src="/assets/backend/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="/assets/backend/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />
    
    <!-- Icons css -->
    <link href="/assets/backend/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>
<body class="authentication-bg pb-0">
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box" style="width:350px;">
            <div class="card-body d-flex flex-column h-100">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="/" class="logo-dark text-center" > 
                        <span><img src="{{ asset('/assets/frontend/images/logo.png') }}" alt="dark logo" style="width:42%;"></span>
                    </a>
                    <a href="/" class="logo-light">
                        <span><img src="{{ asset('/assets/frontend/images/logo.png') }}" alt="logo" style="width:200px; height:50px;" ></span>
                    </a>
                </div>

                <div class="my-auto">

                    <!-- Toggle Buttons -->
                    <div class="text-end mb-4">
                        <button id="btnEmailForm" class="btn btn-sm btn-outline-primary me-1 active">Use Email</button>
                        <button id="btnPhoneForm" class="btn btn-sm btn-outline-primary">Use Phone/OTP</button>
                    </div>

                    @if($errors->has('invalid_credential'))  
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first('invalid_credential') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>                                                 
                    @endif  

                    <!-- form -->
                    <form id="emailForm" method="post" action="{{route('backend.login')}}">
                        @csrf
                                        
                        <!-- title-->
                        <h4 class="mt-0">Sign In</h4>
                        <p class="text-muted mb-4">Enter your email address and password to access account.</p>
                        
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" id="emailaddress" name="email" required="" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <!--<a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Forgot your password?</small></a>-->
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In </button>
                        </div>
                        <!-- social-->
                        {{--
                        <div class="text-center mt-4">
                            <p class="text-muted font-16">Sign in with</p>
                            <ul class="social-list list-inline mt-3">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                        --}}
                    </form>
                    <!-- end form-->

                    <!-- ==== PHONE/OTP FORM ==== -->
                    <form id="phoneForm" method="POST" action="{{ route('backend.login.phone.send') }}" style="display: none;">
                        @csrf
                        <h4 class="mb-3">Sign In with Phone</h4>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input
                                class="form-control"
                                type="text"
                                id="phone"
                                name="phone"
                                required
                                placeholder="Enter your phone (e.g. 91XXXXXXXXXX)">
                        </div>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-cellphone-iphone"></i> Send OTP
                            </button>
                        </div>
                    </form>
                    <!-- end phone form -->
                    
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                   {{-- <p class="text-muted">Don't have an account? <a href="pages-register-2.html" class="text-muted ms-1"><b>Sign Up</b></a></p> --}}
                </footer>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center" 
            style="background-image:url(/assets/frontend/images/calculator_images.JPG);
                   background-size: cover;
                   background-position: center center;">
            <!--<div class="auth-user-testimonial">
                <h2 class="mb-3">I love the color!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent templete. I love it very much! . <i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Nexgeno
                </p>
            </div>--> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->
    <!-- Vendor js -->
    <script src="/assets/backend/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="/assets/backend/js/app.min.js"></script>


    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
{{-- ===== Minimal JS to toggle forms ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEmail = document.getElementById('btnEmailForm');
        const btnPhone = document.getElementById('btnPhoneForm');
        const emailForm = document.getElementById('emailForm');
        const phoneForm = document.getElementById('phoneForm');

        btnEmail.addEventListener('click', function () {
            btnEmail.classList.add('active');
            btnPhone.classList.remove('active');
            emailForm.style.display = 'block';
            phoneForm.style.display = 'none';
        });

        btnPhone.addEventListener('click', function () {
            btnPhone.classList.add('active');
            btnEmail.classList.remove('active');
            phoneForm.style.display = 'block';
            emailForm.style.display = 'none';
        });
    });
</script>
</body>
</html>