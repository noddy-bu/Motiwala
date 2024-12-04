@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala Jewels | Shop luxury jewellery | Get Pure Gold at Best Price')

@section('page.description', 'Discover the elegance of Motiwala Jewels, your destination for exquisite gold and diamond jewellery. Explore our stunning diamond jewellery collection and the exclusive Motiwala Jewels Golden Treasure, featuring timeless designs crafted to perfection Shop luxury jewelry today')

@section('page.type', 'website')

@section('page.content')

    @php
        $plan_details = DB::table('plans')
            ->where('status', 1)
            ->select(['id', 'minimum_installment_amount','receivable_percentage_on_time'])
            ->get();

        $plan_min_amount_plan_1 = $plan_details->firstWhere('id', 1)?->minimum_installment_amount;
        $plan_min_amount_plan_2 = $plan_details->firstWhere('id', 2)?->minimum_installment_amount;

        // $receivable_percentage_on_time = DB::table('plans')
        //     ->where('status', 1)
        //     ->select(['id', 'receivable_percentage_on_time'])
        //     ->get();

        $receivable_percentage_on_time_plan_1 = $plan_details->firstWhere('id', 1)?->receivable_percentage_on_time;
        $receivable_percentage_on_time_plan_2 = $plan_details->firstWhere('id', 2)?->receivable_percentage_on_time;

    @endphp


    <style>
        header {
            background: #fff !important;
        }
    </style>
    <!--banner start -->
    <!-- <section class="banner_section">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    
                <div class="carousel-item active">
                        <img src="/assets/frontend/images/banner1.png" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                        <img src="/assets/frontend/images/banner2.png" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                        <img src="/assets/frontend/images/banner3.png" class="d-block w-100" alt="...">
                </div>

                     <!-- <div class="carousel-item active">
                        <img src="/assets/frontend/images/main_banner_images.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <h3 class="black_color heading_font">Discover the magic of Gold And Diamond Jewellery right here</h3>
                            <p class="black_color">
                                Explore our exquisite collection of Gold and Diamond Jewellery,
                                featuring stunning pieces crafted with precision and care, promising unmatched
                                quality and beauty for every occasion.
                            </p>
                            <div class="buttonclass mt-4">
                                <a href="">Explore <i class="las la-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                
            </div>
        </section> -->


    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <a href="#pay_installments">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/assets/frontend/images/1.jpg" class="d-md-block d-none w-100"
                        alt="...">
                    <img src="/assets/frontend/images/5-new.jpg" class="d-md-none d-block w-100"
                        alt="...">
                </div>

                <div class="carousel-item ">
                    <img src="/assets/frontend/images/2.jpg" class="d-md-block d-none w-100"
                        alt="...">
                    <img src="/assets/frontend/images/6-new.jpg" class="d-md-none d-block w-100"
                        alt="...">
                </div>

                <div class="carousel-item">
                    <img src="/assets/frontend/images/3.jpg" class="d-md-block d-none w-100"
                        alt="...">
                    <img src="/assets/frontend/images/7-new.jpg" class="d-md-none d-block w-100"
                        alt="...">
                </div>

                <div class="carousel-item">
                    <img src="/assets/frontend/images/4.jpg" class="d-md-block d-none w-100"
                        alt="...">
                    <img src="/assets/frontend/images/8-new.jpg" class="d-md-none d-block w-100"
                        alt="...">
                </div>




            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </a>
    </div>


    <!--banner close -->
    <main class="main" id="home_page">
        <!--benefits calculator open-->

        <section class="top_step_content">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-3 heading_font">Dreaming of owning that <span
                        class="stunning_necklace"> stunning jewellery? </span></h4>
                <p class="text-center black_color fontsize26">
                    Start your journey by opening a Motiwala Jewels Golden Treasure account with just ₹3000.
                    <span> By making regular fixed payments for {{ env('PLAN_1') }}, you'll unlock a fantastic discount of up </span>
                    to 100% off the value of your first installment. Get ready to adorn yourself with the perfect necklace!
                </p>
                <div class="text-center">
                    <div class="buttonclass mt-4 ">
                        <a href="{{ url(route('account.new.enrollment.page')) }}">Start Now <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>



        <section class="steps_section" id="pay_installments">
            <div class="container">
                <div class="row">
                    <h4 class="title_heading text-center black_color heading_font">4 Easy Steps </h4>
                    <p class="text-center pb-lg-5 pb-md-3 pb-0 mb-1 black_color ">to purchase the jewellery of your dreams
                    </p>
                    <div class="col-lg-3 col-12">
                        <div class="step_box steps1">

                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/user_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                            <div class="layer_img">
                                <img src="/assets/frontend/images/layer_1.png" class="d-block" alt="...">
                            </div>
                            <div class="step_content1 pt-lg-4 pt-0">
                                <p class="black_color text-center">
                                    Get started by opening a new account on our website, the Motiwala
                                    Jewels Golden Treasure Jewellery Purchase app,
                                    or by visiting our only Store In Byculla, Mumbai Maharashtra.
                                </p>
                            </div>



                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="step_box steps2">
                            <div class="step_content2 pb-lg -3 pb-0">
                                <p class="black_color text-center" >
                                    You can pay a monthly installment of at least ₹3000, or any higher multiples of ₹1000, 
                                    for {{ env('PLAN_1') }} using cash, online banking via Standing Instructions, Net-Banking, 
                                    UPI or post-dated cheque facilities.
                                </p>
                            </div>

                            <div class="layer_img2">
                                <img src="/assets/frontend/images/layer_2.png" class="d-block" alt="...">
                            </div>
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/wallet_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="step_box steps3">

                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/percent_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                            <div class="layer_img3">
                                <img src="/assets/frontend/images/layer_1.png" class="d-block" alt="...">
                            </div>
                            <div class="step_content3 pt-lg-4 pt-md-2  pe-lg-3 ps-lg-4">
                                <p class="black_color text-center">
                                    Receive an exclusive discount of up to 100% of the value of your first installment when
                                    you redeem your plan.
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="step_box steps4">
                            <div class="step_content4 pb-1">
                                <p class="black_color text-center">
                                    Acquire your beloved Motiwala Jewels Gold and Diamonds jewellery using the entire
                                    redemption value.
                                </p>
                            </div>
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/gold_icons.png" class="d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <div class="container">
            <nav class="nav nav-tabs ps-md-5 border-0 gap-3" id="nav-sip-calculator-tab" role="tablist">
                <a class="nav-link active text-dark text-decoration-none" id="nav-sip-calculator1-tab"
                    data-bs-toggle="tab" href="#sip-calculator1" role="tab" aria-controls="nav-home"
                    aria-selected="true">{{ env('PLAN_1_NAME') }}</a>
                <a class="nav-link text-dark text-decoration-none" id="nav-sip-calculator2-tab" data-bs-toggle="tab"
                    href="#sip-calculator2" role="tab" aria-controls="nav-profile" aria-selected="false">{{ env('PLAN_2_NAME') }}</a>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="sip-calculator1" role="tabpanel"
                    aria-labelledby="nav-sip-calculator1-tab">
                    <div class="benefits_calculator sip-calculator">
                        <div class="benefits_bgimage">
                            <img src="/assets/frontend/images/calculator_images.JPG" class="d-block" alt="...">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="title_heading text-left black_color pb-lg-5 pb-md-4 pb-3 heading_font">{{ env('PLAN_1_NAME') }} Calculator</h4>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Enter monthly installment amount</p>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="sip-calculator-amount">
                                                <div class="amount_monthly1">
                                                    <label id="amountLabel"> MONTHLY AMOUNT <span id="amount"></span>
                                                    </label>
                                                    <span class="WebRupee">₹
                                                        <input type="tel" id="calc" name="calc"
                                                            class="text-input form-control min-value_1000 multiple-of_100 slider-value calc"
                                                            value="10000">
                                                    </span>
                                                </div>
                                                <div class="amount_check">
                                                    <div class="row ">
                                                        <div class="col-md-12 d-flex">
                                                            <button id="amount_plus" class="btn btn-block btn-primary">
                                                                <i class="las la-plus"></i>
                                                            </button>
                                                            <button id="amount_minus" class="btn btn-block btn-primary">
                                                                <i class="las la-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="float-start ps-1 pt-1" id="validationMessage"
                                                    style="color: red; display: none;">Accept only multiples of thousand
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="sip-calculator-amount">
                                                <div class="amount_monthly2">
                                                    <label id="amountLabel"> YOUR TOTAL AMOUNT for {{ env('PLAN_1') }}th month  <span
                                                            id="amount_10x">₹ 110,000</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pt-2">You can Buy Jewellery worth: (in 12th month)</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="total_number_main">
                                                <p id="amount_13x" class="amount_13x">₹ 1,20,000</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="sip-calculator2" role="tabpanel"
                    aria-labelledby="nav-sip-calculator2-tab">
                    <div class="benefits_calculator sip-calculator">
                        <div class="benefits_bgimage">
                            <img src="/assets/frontend/images/calculator_images.JPG" class="d-block" alt="...">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="title_heading text-left black_color pb-lg-5 pb-md-4 pb-3 heading_font">{{ env('PLAN_2_NAME') }} Calculator</h4>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Enter monthly installment amount</p>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="sip-calculator-amount">
                                                <div class="amount_monthly1">
                                                    <label id="amountLabel"> MONTHLY AMOUNT <span id="amount_plan2"></span>
                                                    </label>
                                                    <span class="WebRupee">₹
                                                        <input type="tel" id="calc_plan2" name="calc"
                                                            class="text-input form-control min-value_1000 multiple-of_100 slider-value calc"
                                                            value="10000">
                                                    </span>
                                                </div>
                                                <div class="amount_check">
                                                    <div class="row ">
                                                        <div class="col-md-12 d-flex">
                                                            <button id="amount_plus_plan2" class="btn btn-block btn-primary">
                                                                <i class="las la-plus"></i>
                                                            </button>
                                                            <button id="amount_minus_plan2" class="btn btn-block btn-primary">
                                                                <i class="las la-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="float-start ps-1 pt-1" id="validationMessage_plan2"
                                                    style="color: red; display: none;">Accept only multiples of thousand
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="sip-calculator-amount">
                                                <div class="amount_monthly2">
                                                    <label id="amountLabel"> YOUR TOTAL AMOUNT for {{ env('PLAN_2') }} <span
                                                            id="amount_10x_plan2">₹ 1,00,000</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pt-2">You can Get Gold worth: <br class="d-none d-md-block"> (in {{ env('PLAN_2_freeze') }}th months )</p>                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="total_number_main">
                                                <p id="amount_13x_plan2" class="amount_13x">100 gm</p>
                                            </div>
                                        </div>
                                        <p></p>
                                        <p>Note : The rate calculation is based on the gold price for 22 karat on the purchase date. <span style="    font-size: 14px;
    color: #c1884e;">(Today Gold Rate 22 kt As Per 1 gram : Rs {{ $gold_price }})</span></p>
                                    </div>
                                </form>
                            </div>
                            <!-- <div class="col-lg-7 col-md-6 col-8">
                                <canvas id="myCanvas" width="300" height="300"></canvas>
                            </div>            -->

                            <div class="col-md-12 text-md-start text-center widths80">
                                <div class="buttonclass mt-md-4 mb-md-0 mb-3">
                                    <a href="{{ url(route('account.new.enrollment.page')) }}">Open a New Account <i
                                            class="las la-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="step_bottom_text">
                    <p class="black_color text-center">
                        “Delivering top-notch quality jewellery with the latest designs at prices <span>you can afford,
                            we bring over a century of industry</span> <span>expertise right to you.”</span>
                    </p>
                    <div class="buttonclass mt-md-4">
                        <a href="{{ url(route('instantpay')) }}">Explore <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>



            <!--why choose us section start-->
            <section class="why_choose_section">
                <div class="container">
                    <h4 class="title_heading text-center black_color pb-md-4 pb-3  heading_font">Why Choose Us ?</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <img class="choose_img" src="/assets/frontend/images/best_icons.png"
                                    class="d-block w-100" alt="...">
                                <div class="choose_content">
                                    <h5 class="black_color">Best Price Guarantee</h5>
                                    <p class="black_color">
                                        We offer the best prices on Diamond Jewellery.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="d-flex gap-3 pb-md-4 pb-2">
                                <img class="choose_img" src="/assets/frontend/images/motiwala_treasure.png"
                                    class="d-block w-100" alt="...">
                                <div class="choose_content">
                                    <h5 class="black_color">Motiwala Treasure</h5>
                                    <p class="black_color">
                                        A unique easy-pay system that gives you a 100% benefit on the value of your first
                                        installment when you redeem your plan.

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="d-flex gap-3 pb-md-4 pb-2">
                                <img class="choose_img" src="/assets/frontend/images/certified_icons.png"
                                    class="d-block w-100" alt="...">
                                <div class="choose_content">
                                    <h5 class="black_color">100% Certified Jewellery</h5>
                                    <p class="black_color">
                                        Our jewellery always comes with a certificate of authentication.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <img class="choose_img" src="/assets/frontend/images/exquisite_jewellery_collection.png"
                                    class="d-block w-100" alt="...">
                                <div class="choose_content">
                                    <h5 class="black_color">Exquisite Jewellery Collection</h5>
                                    <p class="black_color">
                                        Delivering top-notch quality jewellery with the latest designs at prices you can
                                        afford, we bring over a century of industry expertise right to you.

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <img class="choose_img" src="/assets/frontend/images/transparent_pricing.png"
                                    class="d-block w-100" alt="...">
                                <div class="choose_content">
                                    <h5 class="black_color">Transparent Pricing
                                    </h5>
                                    <p class="black_color">
                                        We believe in transparency, providing detailed breakdowns of costs and no hidden
                                        fees, so you know exactly what you're paying for.

                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="d-flex gap-3 pb-md-4 pb-2">
                                <img class="choose_img" src="/assets/frontend/images/exchange_icon.png"
                                    class="d-block w-100" alt="...">
                                <div class="choose_content">
                                    <h5 class="black_color">Expert Craftsmanship</h5>
                                    <p class="black_color">
                                        Our skilled artisans bring over a century of craftsmanship to each piece, ensuring
                                        exceptional quality and attention to detail.
                                    </p>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </section>
            <!--faq start -->


            <section class="faq_section_main">
                <div class="container">
                    <h4 class="title_heading text-center black_color pb-2 pt-2 heading_font">Frequently Asked Questions
                    </h4>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Where
                                    can
                                    I buy ? </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    You can find our exquisite collection of jewellery at our Store In Byculla Mumbai
                                    Maharashtra.
                                    Additionally, you can explore our wide range of designs and make purchases conveniently
                                    through our secure from the comfort of your own home.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> What
                                    can
                                    I buy ? </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Discover a stunning array of options including Earrings, Necklaces, Ring, Bracelets,
                                    Bangle,precious stones, and more crafted with precision and elegance to suit every
                                    occasion. Explore our diverse collections, from classic designs to contemporary styles,
                                    ensuring there's something special for everyone's taste and preferences.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Can I redeem and purchase before {{ env('PLAN_1') }} ?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Enjoy ultimate flexibility with our plan—redeem and purchase before the 11-month period
                                    ends.
                                    Find your perfect piece early? Redeem your plan for a convenient purchase anytime.
                                    Experience satisfaction with the freedom to acquire your favorite jewelry whenever
                                    you're ready.
                                </div>
                            </div>
                        </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> 
                                If I pay for {{ env('PLAN_1') }}, when will I get special discount ? </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Complete 11 monthly payments to qualify for our exclusive discount offer. 
                                Your dedication to our Golden Treasurer program will be rewarded with special savings on your purchase. 
                                Enjoy the benefits of your commitment with this fantastic discount opportunity!
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What other benefits you get? </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Our Golden Treasurer program offers more than just a discount.
                                Experience personalized assistance from our dedicated team throughout your journey.
                                Enjoy top-quality craftsmanship and excellent service standards with every piece.
                                Our prompt responses to your queries ensure a seamless and satisfying shopping
                                experience.

                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </section>

            <!--faq end -->

            <section class="trusted_jeweller_main">
                <div class="container">
                    <div class="trusted_jeweller_div trusted_jeweller_div_1">
                        <h1 class="trusted_jeweller_heading byculla_heading">
                            Motiwala Jewels Gold and Diamond Jewellery - Your Trusted Jeweller Byculla Mumbai
                        </h1>
                        <p class="trusted_jeweller_p1">
                            At Motiwala Jewels, we pride ourselves on being Mumbai's premier destination for 
                            exquisite gold and diamond jewellery. Our extensive collection offers something for everyone, 
                            whether you’re searching for a stunning piece for a special occasion or a timeless treasure 
                            to add to your collection. With our commitment to quality and craftsmanship, we ensure that 
                            every piece meets the highest standards.
                        </p>
                    </div>
                    <div class="trusted_jeweller_div trusted_jeweller_div_2">
                        <h2 class="trusted_jeweller_heading get_pure_gold_heading">Get Pure Gold Best Price at Motiwala Jewels</h2>
                        <p class="trusted_jeweller_p2">
                            At <a href="https://motiwalajewels.in/" class="trusted_jeweller_link"> Motiwala Jewels</a>, 
                            we believe in providing our customers with the best value for their investments. 
                            Here’s why our pure gold jewellery stands out:
                        </p>
                        <ul class="get_pure_gold_list">
                            <li>
                                <strong>High Purity Levels:</strong> We guarantee that all our gold jewellery is crafted from 22K gold, ensuring unmatched purity.
                            </li>
                            <li>
                                <strong>Competitive Pricing:</strong> Our transparent pricing model ensures you get the best rates without hidden costs.
                            </li>
                            <li>
                                <strong>Customization Options:</strong> Choose from our extensive range of designs or collaborate with our artisans to create a unique piece tailored to your taste.
                            </li>
                            <li>
                                <strong>Quality Assurance:</strong> Each piece is meticulously inspected for quality, ensuring durability and elegance.
                            </li>
                            <li>
                                <strong>Ethical Sourcing:</strong> We are committed to ethical sourcing practices, ensuring that our gold comes from conflict-free origins.
                            </li>
                        </ul>
                    </div>
                    <div class="trusted_jeweller_div trusted_jeweller_div_3">
                        <h3 class="trusted_jeweller_heading golden_culture">
                            Golden Culture: Diamond Jewellers at Motiwala Jewels
                        </h3>
                        <p class="trusted_jeweller_p2">
                            Motiwala Jewels is not just about gold; we also specialize in stunning diamond 
                            jewellery that adds elegance to any attire. Here’s what makes our diamond collection 
                            special:
                        </p>
                        <ul class="golden_culture_list">
                            <li>
                                <strong>Certified Diamonds:</strong> Our diamonds come with certification, ensuring their quality and authenticity.
                            </li>
                            <li>
                                <strong>Variety of Designs:</strong> From classic solitaires to 0intricate designs, we offer a wide range to suit every style.
                            </li>
                            <li>
                                <strong>Expert Craftsmanship:</strong> Our skilled artisans use advanced techniques to enhance the beauty of each piece.
                            </li>
                            <li>
                                <strong>Personalized Service:</strong> We provide personalized consultations to help you choose the perfect piece for any occasion.
                            </li>
                            <li>
                                <strong>Timely Delivery:</strong> Enjoy quick and reliable delivery services, ensuring you receive your jewellery when you need it.
                            </li>
                        </ul>
                    </div>
                </div>
            </section>


    </main>


@endsection


@section('page.scripts')

    <script>
        {{--
        // document.getElementById(['calc','calc2']).addEventListener('input', function(event) {
        //     this.value = this.value.replace(/[^0-9]/g, '');
        // });
        --}}

        const inputIds = ['calc', 'calc_plan2'];

        inputIds.forEach(function(id) {
            document.getElementById(id).addEventListener('input', function(event) {
                this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numeric input
            });
        });

        let total_amount = 100000;
        let discount_amount = 10000;

        // Function to generate data dynamically based on discount_amount and total_amount
        function generateData(discount_amount, total_amount) {
            return [{
                    percentage: 0.3,
                    fillColor: "#DEB599",
                    label: `Discount ₹${discount_amount.toLocaleString()}`,
                    textColor: "#000",
                },
                {
                    percentage: 0.7,
                    fillColor: "#FFDEC7",
                    label: `Pay ₹${total_amount.toLocaleString()}`,
                    textColor: "#000",
                },
            ];
        }


        // Update data and redraw when discount_amount or total_amount changes
        function updateDataAndRedraw() {
            data = generateData(discount_amount, total_amount);
            HoverPie.make($("#myCanvas"), data, {});
        }

        {{--
        // function roundToNearestThousand(amount) {
        //     return Math.ceil(amount / 1000) * 1000;
        // }


        //   document.addEventListener('DOMContentLoaded', function() {
        //     const amountSpan = document.getElementById('amount');
        //     const amount10xSpan = document.getElementById('amount_10x');
        //     const amount13xSpan = document.getElementById('amount_13x');

        //     const amountPlusBtn = document.getElementById('amount_plus');
        //     const amountMinusBtn = document.getElementById('amount_minus');

        //     let currentAmount = 10000;


        //     function updateAmount() {
        //         amountSpan.textContent = '₹ ' + Math.ceil(currentAmount).toLocaleString();
        //         amount10xSpan.textContent = '₹ ' +  Math.ceil(currentAmount * {{ $plan1_duration }}).toLocaleString();
        //         amount13xSpan.textContent = '₹ ' +  roundToNearestThousand((currentAmount * {{ $plan1_duration }}) * 1.0909).toLocaleString();

        //         total_amount = Math.ceil(currentAmount * {{ $plan1_duration }});
        //         discount_amount = roundToNearestThousand((currentAmount * {{ $plan1_duration }}) * 1.0909) - total_amount;

        //         updateDataAndRedraw();
        //     }



        //     amountPlusBtn.addEventListener('click', function(event) {
        //         event.preventDefault();
        //         currentAmount += 1000;
        //         updateAmount();
        //     });

        //     amountMinusBtn.addEventListener('click', function(event) {
        //         event.preventDefault();
        //         if (currentAmount > {{ $plan_min_amount_plan_1 }}) {
        //             currentAmount -= 1000;
        //             updateAmount();
        //         }
        //     });

        //     updateAmount();
        // });


        /* ----- calculate -------- */

        // document.addEventListener('DOMContentLoaded', function() {
        //     const amountSpan = document.getElementById('amount');
        //     const amount10xSpan = document.getElementById('amount_10x');
        //     const amount13xSpan = document.getElementById('amount_13x');
        //     const calcInput = document.getElementById('calc');
        //     const validationMessage = document.getElementById('validationMessage');

        //     const amountPlusBtn = document.getElementById('amount_plus');
        //     const amountMinusBtn = document.getElementById('amount_minus');

        //     let currentAmount = parseInt(calcInput.value, 10);

        //     function roundToNearestThousand(amount) {
        //         return Math.ceil(amount / 1000) * 1000;
        //     }

        //     function updateAmount() {
        //         if (currentAmount % 1000 !== 0) {
        //             validationMessage.style.display = 'block';
        //             return;
        //         } else {
        //             validationMessage.style.display = 'none';
        //         }

        //         amountSpan.textContent = '₹ ' + Math.ceil(currentAmount).toLocaleString();
        //         amount10xSpan.textContent = '₹ ' + Math.ceil(currentAmount * {{ $plan1_duration }}).toLocaleString();
        //         amount13xSpan.textContent = '₹ ' + roundToNearestThousand((currentAmount * {{ $plan1_duration }}) * 1.0909).toLocaleString();

        //         // Perform additional calculations if necessary
        //     }

        //     calcInput.addEventListener('input', function() {
        //         currentAmount = parseInt(calcInput.value, {{ $plan1_duration }}) || 0;
        //         updateAmount();
        //     });

        //     amountPlusBtn.addEventListener('click', function(event) {
        //         event.preventDefault();
        //         currentAmount += 1000;
        //         calcInput.value = currentAmount;
        //         updateAmount();
        //     });

        //     amountMinusBtn.addEventListener('click', function(event) {
        //         event.preventDefault();
        //         if (currentAmount > {{ $plan_min_amount_plan_1 }}) {
        //             currentAmount -= 1000;
        //             calcInput.value = currentAmount;
        //             updateAmount();
        //         }
        //     });

        //     updateAmount(); // Initial update
        // });
        --}}

        function roundToNearestThousand(amount) {
            return Math.ceil(amount / 1000) * 1000;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const amountSpan = document.getElementById('amount');
            const amount10xSpan = document.getElementById('amount_10x');
            const amount13xSpan = document.getElementById('amount_13x');
            const calcInput = document.getElementById('calc');
            const validationMessage = $('#validationMessage');

            const amountPlusBtn = document.getElementById('amount_plus');
            const amountMinusBtn = document.getElementById('amount_minus');

            let currentAmount = parseInt(calcInput.value);



            function updateAmount() {
                if (currentAmount % 1000 !== 0) {
                    validationMessage.html('Accept only multiples of thousand');
                    validationMessage.show();
                    return;
                } else {
                    validationMessage.hide();
                }

                amountSpan.textContent = '₹ ' + Math.ceil(currentAmount).toLocaleString();
                amount10xSpan.textContent = '₹ ' + Math.ceil(currentAmount * {{ $plan1_duration }})
            .toLocaleString();

                var profit_percantage = (currentAmount * {{ $receivable_percentage_on_time_plan_1 }}) / 100;
                var profit = {{ $plan1_duration }} * profit_percantage;

                amount13xSpan.textContent = '₹ ' + ((currentAmount * {{ $plan1_duration }}) + profit)
                    .toLocaleString();
            }

            calcInput.addEventListener('input', function() {
                currentAmount = parseInt(calcInput.value) || 0;

                if (currentAmount < {{ $plan_min_amount_plan_1 }}) {
                    validationMessage.html('Minimum amount should be ' + roundToNearestThousand(
                        {{ $plan_min_amount_plan_1 }}));
                    validationMessage.show();
                    return;
                } else {
                    validationMessage.hide();
                }
                updateAmount();
            });

            amountPlusBtn.addEventListener('click', function(event) {
                event.preventDefault();


                if (currentAmount < {{ $plan_min_amount_plan_1 }}) {
                    validationMessage.html('Minimum amount should be ' + roundToNearestThousand(
                        {{ $plan_min_amount_plan_1 }}));
                    validationMessage.show();
                } else {
                    currentAmount += 1000;
                    calcInput.value = currentAmount;
                    updateAmount();
                }

            });

            amountMinusBtn.addEventListener('click', function(event) {
                event.preventDefault();
                if (currentAmount > {{ $plan_min_amount_plan_1 }}) {
                    currentAmount -= 1000;
                    calcInput.value = currentAmount;
                    updateAmount();
                } else {
                    validationMessage.html('Minimum amount should be ' + roundToNearestThousand(
                        {{ $plan_min_amount_plan_1 }}));
                    validationMessage.show();
                }
            });

            updateAmount(); // Initial update
        });


        /* ----- calculate plan 1 -------- */

        /* ----- Calculate plan 2 -------- */

        document.addEventListener('DOMContentLoaded', function() {
            const amountSpan_plan2 = document.getElementById('amount_plan2');
            const amount10xSpan_plan2 = document.getElementById('amount_10x_plan2');
            const amount13xSpan_plan2 = document.getElementById('amount_13x_plan2');
            const calcInput_plan2 = document.getElementById('calc_plan2');
            const validationMessage_plan2 = $('#validationMessage_plan2');

            const amountPlusBtn_plan2 = document.getElementById('amount_plus_plan2');
            const amountMinusBtn_plan2 = document.getElementById('amount_minus_plan2');

            // let currentAmount_plan2 = parseInt(calcInput_plan2.value, {{ $plan2_duration }});
            let currentAmount_plan2 = parseInt(calcInput_plan2.value);

            function updateAmount_plan2() {
                if (currentAmount_plan2 % 1000 !== 0) {
                    validationMessage_plan2.html('Accept only multiples of thousand');
                    validationMessage_plan2.show();
                    return;
                } else {
                    validationMessage_plan2.hide();
                }

                amountSpan_plan2.textContent = '₹ ' + Math.ceil(currentAmount_plan2).toLocaleString();
                amount10xSpan_plan2.textContent = '₹ ' + Math.ceil(currentAmount_plan2 * {{ $plan2_duration }}).toLocaleString();

                var profit_percantage = (currentAmount_plan2 * {{ $receivable_percentage_on_time_plan_2 }}) / 100;
                var profit = {{ $plan2_duration }} * profit_percantage;

                var total_amt_for_gold = ((currentAmount_plan2 * {{ $plan2_duration }}) + profit);
                var gold_rate = ({{ $gold_price }} * 10);

                console.log(gold_rate);

                var grams_of_gold = ((total_amt_for_gold / gold_rate) * 10);

                console.log(grams_of_gold);

                amount13xSpan_plan2.textContent = (grams_of_gold).toLocaleString() + ' Gram (22 karat)';
            }

            calcInput_plan2.addEventListener('input', function() {
                currentAmount_plan2 = parseInt(calcInput_plan2.value) || 0;
                if (currentAmount_plan2 < {{ $plan_min_amount_plan_2 }}) {
                    validationMessage_plan2.html('Minimum amount should be ' + roundToNearestThousand(
                        {{ $plan_min_amount_plan_2 }}));
                    validationMessage_plan2.show();
                    return;
                } else {
                    validationMessage_plan2.hide();
                }
                updateAmount_plan2();
            });

            amountPlusBtn_plan2.addEventListener('click', function(event) {
                event.preventDefault();


                if (currentAmount_plan2 < {{ $plan_min_amount_plan_2 }}) {
                    validationMessage_plan2.html('Minimum amount should be ' + roundToNearestThousand(
                        {{ $plan_min_amount_plan_2 }}));
                    validationMessage_plan2.show();
                } else {
                    currentAmount_plan2 += 1000;
                    calcInput_plan2.value = currentAmount_plan2;
                    updateAmount_plan2();
                }

            });

            amountMinusBtn_plan2.addEventListener('click', function(event) {
                event.preventDefault();
                if (currentAmount_plan2 > {{ $plan_min_amount_plan_2 }}) {
                    currentAmount_plan2 -= 1000;
                    calcInput_plan2.value = currentAmount_plan2;
                    updateAmount_plan2();
                } else {
                    validationMessage_plan2.html('Minimum amount should be ' + roundToNearestThousand(
                        {{ $plan_min_amount_plan_2 }}));
                    validationMessage_plan2.show();
                }
            });

            updateAmount_plan2(); // Initial update
        });


        /* ----- Calculate plan 2 --------*/




        /* canvass graph open */

        console.log("vvvvvvvvvvvvvvvvvvvv KSF vvvvvvvvvvvvvvvvvvvv");
        {{--
        // var HoverPie = {};
        // HoverPie.config = {
        //     canvasPadding: 1,
        //     hoverScaleX: 5.1,
        //     hoverScaleY: 1.1,
        //     labelColor: "#000",
        //     labelHoverColor: "rgba(255,255,255,1)",
        //     labelRadiusFactor: 0.66,
        //     labelFontFamily: "Quicksand",
        //     labelFontWeight: "bold",
        //     labelAlign: "center",
        //     labelFontSize: 12,
        //     sectorFillColor: "#000",
        //     sectorStrokeColor: "#000",
        //     sectorStrokeWidth: 2,
        // };
        // HoverPie.make = function($canvas, data, config) {
        //     config = $.extend({}, HoverPie.config, config);

        //     var percent2radians = function(percent) {
        //         return percent * Math.PI * 2;
        //     };

        //     var ctx = $canvas[0].getContext("2d");
        //     var oX = ctx.canvas.width / 2;
        //     var oY = ctx.canvas.height / 2;
        //     var r = Math.min(oX, oY) - config.canvasPadding;
        //     var stage = new createjs.Stage("myCanvas");
        //     stage.enableMouseOver(20);

        //     var cumulativeAngle = 1.5 * Math.PI;

        //     for (var i = 0; i < data.length; i++) {
        //         var sector = new createjs.Shape();
        //         var container = new createjs.Container();
        //         container.name = container.id;

        //         // Draw the arc
        //         var sectorFillColor = data[i].fillColor || config.sectorFillColor;
        //         var sectorStrokeColor = data[i].strokeColor || config.sectorStrokeColor;
        //         sector.graphics
        //             .moveTo(oX, oY)
        //             .beginFill(sectorFillColor)
        //             .setStrokeStyle(config.sectorStrokeWidth)
        //             .beginStroke(sectorStrokeColor);

        //         var sectorAngle = percent2radians(data[i].percentage);
        //         sector.graphics.arc(
        //             oX,
        //             oY,
        //             r,
        //             cumulativeAngle,
        //             cumulativeAngle + sectorAngle
        //         );

        //         sector.graphics.closePath();

        //         container.addChild(sector);

        //         // Draw the label
        //         if (data[i].label) {
        //             // One for unhovered sectors
        //             var font =
        //                 config.labelFontWeight +
        //                 " " +
        //                 config.labelFontSize +
        //                 "px " +
        //                 config.labelFontFamily;
        //             var unhoverLabel = new createjs.Text(
        //                 data[i].label,
        //                 font,
        //                 config.labelColor
        //             );
        //             unhoverLabel.textAlign = "center";
        //             unhoverLabel.textBaseline = "bottom";

        //             // The label is to be placed such that the center of its baseline
        //             // is tangent to a circle of radius r*config.labelRadiusFactor
        //             // and a line drawn along the center of the sector
        //             var unhoverLabelRadius = r * config.labelRadiusFactor;
        //             var unhoverLabelAngle = cumulativeAngle + sectorAngle / 2.0;
        //             unhoverLabel.x =
        //                 oX + unhoverLabelRadius * Math.cos(unhoverLabelAngle);
        //             unhoverLabel.y =
        //                 oY + unhoverLabelRadius * Math.sin(unhoverLabelAngle);
        //             unhoverLabel.name = "label";

        //             // and one for hovered sectors

        //             container.addChild(unhoverLabel);
        //         }

        //         // Draw the description

        //         // reposition scale origin and draw origin
        //         container.regX = oX;
        //         container.regY = oY;
        //         container.x = oX;
        //         container.y = oY;

        //         cumulativeAngle += sectorAngle;
        //         stage.addChild(container);
        //         stage.update();
        //     } // percentages loop

        //     // This array tracks the currently-hovered pie sectors.
        //     // if it is empty, there are no sectors hovered.
        //     var hovers = [];

        //     var hover = function(ids) {
        //         //console.log(ids,stage.children);

        //         // This function is to be called with a list of stage IDs
        //         // it will revert any currently-hovered elements to their
        //         // original style, and apply hover style to the new set.

        //         // any ids in hovers that aren't in ids need to be unhovered
        //         var toUnhover = [];
        //         for (var i = 0; i < hovers.length; i++) {
        //             if (ids.indexOf(hovers[i]) == -1) {
        //                 // didn't find hover[i] in ids, so add to toUnhover
        //                 toUnhover.push(hovers[i]);
        //             }
        //         }
        //         for (var i = 0; i < toUnhover.length; i++) {
        //             var child = stage.getChildByName(toUnhover[i]);
        //             child.scaleX = 1;
        //             child.scaleY = 1;
        //         }

        //         // and ids in ids that aren't in hovers need to be hovered
        //         var toHover = [];
        //         for (var i = 0; i < ids.length; i++) {
        //             if (hovers.indexOf(ids[i]) == -1) {
        //                 // didn't find ids[i] in hovers, so add to toHover
        //                 toHover.push(ids[i]);
        //             }
        //         }
        //         for (var i = 0; i < toHover.length; i++) {
        //             var child = stage.getChildByName(toHover[i]);
        //             child.scaleX = config.hoverScaleX;
        //             child.scaleY = config.hoverScaleY;
        //         }

        //         hovers = ids;
        //         stage.update();
        //     };

        //     $canvas.mousemove(function(e) {
        //         var objs = stage.getObjectsUnderPoint(e.clientX, e.clientY);
        //         var ids = $.map(objs, function(e) {
        //             return e.parent.id;
        //         });

        //         // call hover() if ids does not match current hovers
        //         if (ids.length != hovers.length) {
        //             hover(ids);
        //             return;
        //         }
        //         for (var i = 0; i < hovers.length; i++) {
        //             if (ids[i] != hovers[i]) {
        //                 hover(ids);
        //                 return;
        //             }
        //         }
        //     });
        // };

        // var data = generateData(discount_amount, total_amount);
        // HoverPie.make($("#myCanvas"), data, {});
        --}}
    </script>

@endsection
