<header class="w-100 z-index-1">
    <nav class="navbar navbar-expand-lg ">
        <div class="container">
            <a class="navbar-brand" href="{{ url(route('index')) }}"><img
                    src="{{ asset('/assets/frontend/images/logo.png') }}"></a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="d-flex align-items-center" id="navbarScroll">
                <ul class="d-flex navbar-nav ms-md-auto my-md-2 my-lg-0 my-0 mx-0 nav_right_menu ">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="modal" href="#loginmodal"><i class="las la-user"></i> Sign
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url(route('account.new.enrollment.page')) }}"><i
                                class="las la-user-plus"></i> New Account</a>
                    </li>
                </ul>

                <a id="nav-icon">
                  <span class="fa fa-bars"></span>
                </a>
                <ul class="menu">
                  <img src="https://demo.creaadesign.com/bandhan-mutual-fund/images/cross2.svg" alt="" class="img-fluid cross_close">
                  <li>
                    <a class="nav-link" href="{{ url(route('instantpay')) }}"><i class="las la-hand-holding-usd"></i> Instant Pay</a>
                  </li>
                  <li>
                    <a class="nav-link" data-bs-toggle="modal" href="#autodebit_modal"><i
                                        class="las la-credit-card"></i> Auto Debit</a>
                  </li>
                  <li>
                    <a class="nav-link" href="{{ url(route('information')) }}"><i class="las la-exclamation-circle"></i>
                                    Information</a>
                  </li>
                  <li>
                    <a class="nav-link" href="{{ url(route('terms')) }}"><i class="las la-clipboard-list"></i>
                                    T&C</a>
                  </li>
                  <li>
                    <a class="nav-link" href="{{ url(route('faq')) }}"><i class="las la-question-circle"></i> FAQs</a>
                  </li>

                   <li>
                    <a class="nav-link" href="contact-us"><i class="las la-question-circle"></i> Contact Us</a>
                  </li>
                

                  
                </ul>

            </div>
 
       
        
      </nav>
        </div>
    </nav>
</header>
