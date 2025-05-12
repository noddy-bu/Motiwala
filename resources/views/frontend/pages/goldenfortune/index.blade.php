@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

    <!-- -------------------- career banner start ---------------- -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <a href="#pay_installments">
            
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/assets/frontend/images/golden_fortune1.webp" class="d-md-block d-none w-100"
                        alt="golden_fortune1">
                    <img src="/assets/frontend/images/golden_fortune1.webp" class="d-md-none d-block w-100"
                        alt="golden_fortune1">
                </div>
            </div>
           
        </a>
    </div>


    <main class="main">


     <section class="top_step_content">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-3 heading_font">Start Saving in Gold the Smart Way</h4>
                <p class="text-center black_color fontsize26">
                    Start your Golden Fortune journey with just ₹10,000 per month for 12 months and lock in 22K gold at the rate of each payment day. Want to invest more? You can add in multiples of ₹1,000! At the end of the plan, enjoy 0% making charges on your total accumulated gold. It's the smart way to save - let your fortune shine!

                </p>
                <div class="text-center">
                    <div class="buttonclass mt-4 ">
                        <a href="{{ url(route('account.new.enrollment.page')) }}">Start Now <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>


  <section class="treaser_section_page">
        <div class="container">
           
            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane active fade show" id="sip-calculator2" role="tabpanel"
                    aria-labelledby="nav-sip-calculator2-tab">
                    <div class="benefits_calculator sip-calculator">
                        <div class="benefits_bgimage">
                            <img src="/assets/frontend/images/calculator_images.JPG" class="d-block" alt="...">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="title_heading text-left black_color pb-lg-4 pb-md-4 pb-3 heading_font">{{ env('PLAN_2_NAME') }} Plan</h4>
                            </div>
                            <div class="col-lg-8 col-md-8">

                                @include('frontend.component.gold_rate_table')


                                <p class="fs-14 pt-4 pb-2">For more details click here - <a href="/terms-conditions" style="color:#bb8042;">Terms & Conditions</a></p>

                                <p>Note : The rate calculation is based on the gold price for 22 karat on the purchase date. <span style="    font-size: 14px;
    color: #c1884e;">(Today Gold Rate 22 kt As Per 1 gram : Rs {{ $gold_price }})</span></p>


                            </div>
                          
                            <div class="col-md-12 text-md-start text-center widths80">
                                <div class="buttonclass mt-md-3 mb-md-0 mb-3">
                                    <a href="{{ url(route('account.new.enrollment.page')) }}">Open a New Account <i
                                            class="las la-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                                 Choose the Golden Fortune Plan and start with a minimum of ₹10,000/month
                                </p>
                            </div>



                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="step_box steps2">
                            <div class="step_content2 pb-lg -3 pb-0">
                                <p class="black_color text-center" >
                                  Make your payments for 12 consecutive months. Each payment locks in 22K gold at that day’s rate. Want to invest more? Add in ₹1,000 multiples anytime!


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
                                   Once all 12 installments are complete, your gold gets accumulated based on each day’s gold rate.

                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="step_box steps4">
                            <div class="step_content4 pb-1">
                                <p class="black_color text-center">
                                  Within 400 days from the start date, redeem your total gold value with 0% making charges on any jewellery made from your saved gold.

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
                    <h4 class="title_heading text-center black_color pb-3 pt-2 heading_font">Frequently Asked Questions
                    </h4>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Where can I buy ? </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    You can find our exquisite collection of jewellery at our Store In Byculla Mumbai
                                    Maharashtra. Additionally, you can explore our wide range of designs and make purchases conveniently
                                    through our whatsapp from the comfort of your own home.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> What ca I buy ? </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Discover a stunning array of options including Earrings, Necklaces, Ring, Bracelets,
                                    Bangle, precious stones, and more crafted with precision and elegance to suit every
                                    occasion. Explore our diverse collections, from classic designs to contemporary styles,
                                    ensuring there's something special for everyone's taste and preferences.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                   Can I invest more than ₹10,000/month?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Yes! You can increase your investment anytime in ₹1,000 multiples.
                                </div>
                            </div>
                        </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> 
                                Is there any hidden charge? </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                 No hidden charges. In fact, you enjoy 0% making charges at the end of the plan.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                               What happens if I miss a payment? </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Missed months reduce the gold accumulation, but you can still complete the plan.

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                              Can I cancel mid-way? </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Yes, but you won't be eligible for 0% making charges or full benefits.

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
