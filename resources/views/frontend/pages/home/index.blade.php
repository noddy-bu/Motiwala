@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala & Sons')

@section('page.description',
    ' ')

@section('page.type', 'website')

@section('page.content')

    <!--banner start -->
    <section class="banner_section">
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
                    <img src="/assets/frontend/images/main_banner_images.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h3 class="black_color heading_font">Discover the magic of Gold And Diamond Jewellery right here</h3>
                        <p class="black_color">
                            Our website is your gateway to a world of stunning diamonds and exquisite jewellery.
                            We bring you the very best from around the globe, ensuring you find the diamond of your dreams.
                        </p>
                        <div class="buttonclass mt-4">
                            <a href="">Explore <i class="las la-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/assets/frontend/images/main_banner_images.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h3 class="black_color heading_font">Step into a world of looking beautiful with our Gold And Diamond Jewellery collection! </h3>
                        <p class="black_color">Here at our website, you'll embark on a journey through a dazzling array of diamonds and exquisite jewellery. From timeless classics to contemporary stunners,</p>
                        <div class="buttonclass mt-4">
                            <a href="">Explore <i class="las la-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/assets/frontend/images/main_banner_images.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h3 class="black_color heading_font">Embark on a journey of majesty with our Gold And Diamond Jewellery collection! </h3>
                        <p class="black_color">Our online haven welcomes you to explore an enchanting array of diamonds and exquisite jewellery.</p>
                        <div class="buttonclass mt-4">
                            <a href="">Explore <i class="las la-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--banner close -->
    <main class="main">
        <!--benefits calculator open-->
        <section class="steps_section">
            <div class="container">
                <div class="top_step_content">
                    <p class="text-center black_color" data-aos-once="true" data-aos="fade-up">A Dreaming of owning that stunning necklace?</p>
                    <p class="text-center black_color" data-aos-once="true" data-aos="fade-up">
                        Start your journey by opening a Motiwala Jewels Golden Treasure  account with just ₹2000.
                        <span> By making regular fixed payments for 10 months, you'll unlock a fantastic discount of up </span>
                        to 75% off the value of your first installment. Get ready to adorn yourself with the perfect necklace!
                    </p>
                    <h4 class="title_heading text-center black_color pb-1 heading_font pt-4 " data-aos-once="true"
                        data-aos="fade-up">Unlocking your dream jewellery in just 4 simple steps:</h4>
                    <!-- <p class="text-center black_color" data-aos-once="true" data-aos="fade-up">to purchase the jewellery of
                        your dreams</p> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="step_border_img">
                            <img src="/assets/frontend/images/round_bg_image.png" class="d-block" alt="...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="step_box steps1">
                            <div class="step_content1">
                                <p class="black_color" data-aos-once="true" data-aos="fade-right">
                                    Get started by opening a new account on our website, the Motiwala
                                    Jewels Golden Treasure Jewellery Purchase app,
                                    or by visiting  our only  Store In Byculla, Mumbai Maharashtra.
                                </p>
                            </div>
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/user_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="step_box steps2">
                            <div class="step_content2">
                                <p class="black_color" data-aos-once="true" data-aos="fade-right">
                                    You can pay a monthly installment of at least ₹2000, or any higher multiples of ₹1000, 
                                    for 10 months using cash, online banking via Standing Instructions, Net-Banking, 
                                    UPI or post-dated cheque facilities.
                                </p>
                            </div>
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/wallet_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="step_box steps3">
                            <div class="step_content3">
                                <p class="black_color" data-aos-once="true" data-aos="fade-left">
                                    Receive an exclusive discount of up to 75% of the value of your first installment when you redeem your plan.
                                </p>
                            </div>
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/percent_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="step_box steps4">
                            <div class="step_content4">
                                <p class="black_color" data-aos-once="true" data-aos="fade-left">
                                    Acquire your beloved Motiwala Jewels Gold and Diamonds jewellery using the entire redemption value.
                                </p><br><br>
                            </div>
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/gold_icons.png" class="d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step_bottom_text">
                    <p class="black_color text-center" data-aos-once="true" data-aos="fade-up">
                        “Delivering top-notch quality jewellery with the latest designs at prices <span>you can afford,
                         we bring over a century of industry</span> <span>expertise right to you.”</span>
                    </p>
                    <div class="buttonclass mt-4" data-aos-once="true" data-aos="fade-up">
                        <a href="">Explore <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </section>



        <div class="container">
            <div class="benefits_calculator sip-calculator" data-aos-once="true" data-aos="fade-up">
                <h4 class="title_heading text-center black_color pb-3 heading_font">Benefits Calculator</h4>
                <form>
                    <div class="row">

                        <div class="col-md-12">
                            <p>Slide or enter monthly installment amount</p>
                        </div>
                        <div class="col-md-6">

                            <div class="sip-calculator-amount">
                                <div class="amount_monthly1">
                                    <label id="amountLabel"> MONTHLY AMOUNT <span id="amount">₹ 2000</span></label>
                                </div>
                                <div class="amount_check">

                                    <div class="row ">

                                        <div class="col-md-12 d-flex">
                                            <button id="amount_plus" class="btn btn-block btn-primary"><i class="las la-plus"></i></button>
                                       
                                        
                                            <button id="amount_minus" class="btn btn-block btn-primary"> <i class="las la-minus"></i> </button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="sip-calculator-amount">
                                <div class="amount_monthly2">
                                    <label id="amountLabel"> YOUR TOTAL AMOUNT for 10 months <span id="amount_10x">₹
                                            2000</span></label>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <p class="pt-2">You can Buy Jewellery worth: (in 13th month)</p>
                        </div>

                        <div class="col-md-6">
                            <div class="total_number_main">
                                <p id="amount_13x">₹ 22,800</p>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <div class="buttonclass mt-4">
                                <a href="">Open a New Account <i class="las la-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <!--why choose us section start-->
        <section class="why_choose_section">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-4 heading_font">Why Choose Us ?</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex gap-3" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/exchange_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Exquisite Jewellery Collection</h5>
                                <p class="black_color">
                                Delivering top-notch quality jewellery with the latest designs at prices you can afford,
                                we bring over a century of industry expertise right to you.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3 pb-4" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/best_icons.png" class="d-block w-100"
                                alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Best Price Guarantee</h5>
                                <p class="black_color">
                                    Our Best Price Guarantee ensures that you'll find the most competitive prices
                                    in the online diamond jewellery business right here.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3 pb-4" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/refer_icons.png" class="d-block w-100"
                                alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Certified Authenticity</h5>
                                <p class="black_color"> 
                                    Rest assured, our jewellery is always 100% certified,
                                    accompanied by a certificate of authentication for your peace of mind.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3 pb-4" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/earnings_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Lifetime Exchange Policy</h5>
                                <p class="black_color"> 
                                    Upgrade your style anytime with our Lifetime Exchange policy, 
                                    allowing you to exchange your old designs for something new whenever you desire.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="d-flex gap-3" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/exchange_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Lifetime Exchange</h5>
                                <p class="black_color">Exchange your old designs anytime you want an upgrade.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/warranty_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">One Year Warranty</h5>
                                <p class="black_color">If your jewellery has a defect, we will fix it.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!--faq start -->
        <section class="faq_section">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-3 heading_font">Frequently Asked Questions</h4>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item" data-aos-once="true" data-aos="fade-up">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Where can
                                I buy ? </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You can find our exquisite collection of jewellery at our Store In Byculla Mumbai Maharashtra.
                                Additionally, you can explore our wide range of designs and make purchases conveniently 
                                through our secure online store from the comfort of your own home.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" data-aos-once="true" data-aos="fade-up">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> What can
                                I buy ? </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Discover a stunning array of options including Earrings, Necklaces, Ring, Bracelets,
                                Bangle and more,precious stones, crafted with precision and elegance to suit every occasion.
                                Explore our diverse collections, from classic designs to contemporary styles,
                                ensuring there's something special for everyone's taste and preferences
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" data-aos-once="true" data-aos="fade-up">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Can
                                I reedem and purchase before 11 months ? </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Certainly! Our flexible policy allows for redemption and purchase before the 11-month period ends. 
                                Should you find the perfect piece earlier than expected, you're welcome to redeem your plan and 
                                make your desired purchase at your convenience. This ensures that you have the freedom to acquire 
                                your favorite jewellery whenever you're ready, giving you the ultimate flexibility and satisfaction 
                                in your shopping experience with us.
                                <br>
                                Please check
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos-once="true" data-aos="fade-up">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> If I
                                pay for 10 months, when will I get special discount ? </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Absolutely! Upon completing your 10 monthly payments, you'll become eligible for our special discount offer. 
                                This means that once you've diligently paid your installments for the specified duration, 
                                you'll unlock the opportunity to enjoy exclusive savings on your purchase. 
                                It's our way of rewarding your commitment and dedication to our Motiwala Jewels Golden Treasurer Purchase 
                                Plan. So, rest assured that your patience and loyalty will be duly recognized, and you'll be able to 
                                avail yourself of the fantastic discount to make your jewellery purchase even more rewarding.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos-once="true" data-aos="fade-up">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> What
                                other benifits you get? </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                In addition to our special discount offer, our Motiwala Jewels Golden Treasurer Purchase 
                                Plan comes with a range of other benefits tailored to enhance your overall experience. 
                                Firstly, you can expect top-notch service from our dedicated team who are committed to 
                                providing you with personalized assistance every step of the way. Moreover, we prioritize 
                                quality in every aspect of our service, ensuring that you receive jewellery crafted to the 
                                highest standards of craftsmanship and excellence. Furthermore, our prompt and attentive 
                                responses to any queries or concerns you may have reflect our commitment to your satisfaction 
                                and guarantee a seamless and enjoyable shopping experience with us. 
                                <br>
                                Please check
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>


@endsection


@section('page.scripts')

  <script>
      document.addEventListener('DOMContentLoaded', function() {
        const amountSpan = document.getElementById('amount');
        const amount10xSpan = document.getElementById('amount_10x');
        const amount13xSpan = document.getElementById('amount_13x');

        const amountPlusBtn = document.getElementById('amount_plus');
        const amountMinusBtn = document.getElementById('amount_minus');

        let currentAmount = 2000;

        function updateAmount() {
            amountSpan.textContent = '₹ ' + currentAmount.toLocaleString();
            amount10xSpan.textContent = '₹ ' + (currentAmount * 10).toLocaleString();
            amount13xSpan.textContent = '₹ ' + (currentAmount / 1000 * 10750).toLocaleString();
        }

        amountPlusBtn.addEventListener('click', function(event) {
            event.preventDefault();
            currentAmount += 1000;
            updateAmount();
        });

        amountMinusBtn.addEventListener('click', function(event) {
            event.preventDefault();
            if (currentAmount > 2000) {
                currentAmount -= 1000;
                updateAmount();
            }
        });

        updateAmount();
    });
  </script>
  
@endsection
