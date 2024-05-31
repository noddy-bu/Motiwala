@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala & Sons')

@section('page.description',
    ' ')

@section('page.type', 'website')

@section('page.content')

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
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/assets/frontend/images/2.jpg" class="d-md-block d-none w-100" alt="...">
      <img src="/assets/frontend/images/13.jpg" class="d-md-none d-block w-100" alt="...">
    </div>

    <div class="carousel-item">
      <img src="/assets/frontend/images/3.jpg" class="d-md-block d-none w-100" alt="...">
      <img src="/assets/frontend/images/14.jpg" class="d-md-none d-block w-100" alt="...">
    </div>

    <div class="carousel-item">
      <img src="/assets/frontend/images/4.jpg" class="d-md-block d-none w-100" alt="...">
      <img src="/assets/frontend/images/15.jpg" class="d-md-none d-block w-100" alt="...">
    </div>

    <div class="carousel-item">
      <img src="/assets/frontend/images/1.jpg" class="d-md-block d-none w-100" alt="...">
      <img src="/assets/frontend/images/16.jpg" class="d-md-none d-block w-100" alt="...">
    </div>

     

  
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


    <!--banner close -->
    <main class="main">
        <!--benefits calculator open-->

           <section class="top_step_content">
            <div class="container">  <h4 class="title_heading text-center black_color pb-3 heading_font">Dreaming of owning that stunning necklace?</h4>
                <p class="text-center black_color fontsize26" data-aos-once="true" data-aos="fade-up">
                    Start your journey by opening a Motiwala Jewels Golden Treasure  account with just ₹2000.
                    <span> By making regular fixed payments for 10 months, you'll unlock a fantastic discount of up </span>
                    to 75% off the value of your first installment. Get ready to adorn yourself with the perfect necklace!
                </p>
                <div class="text-center">
                    <div class="buttonclass mt-4 " data-aos-once="true" data-aos="fade-up">
                        <a href="/account/onlineenrollment">Start Now <i class="las la-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
</section>



        <section class="steps_section">
            <div class="container">
                <div class="row">
                    <h4 class="title_heading text-center black_color heading_font">4 Easy Steps </h4>
                        <p class="text-center pb-md-5 pb-2 black_color ">to purchase the jewellery of your dreams</p>
                    <div class="col-md-3">
                        <div class="step_box steps1">
                            
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/user_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                                 <div class="layer_img">
                                    <img src="/assets/frontend/images/layer_1.png" class="d-block" alt="...">
                                </div>
                            <div class="step_content1 pt-md-5">
                                <p class="black_color" data-aos-once="true" data-aos="fade-right">
                                    Get started by opening a new account on our website, the Motiwala
                                    Jewels Golden Treasure Jewellery Purchase app,
                                    or by visiting  our only  Store In Byculla, Mumbai Maharashtra.
                                </p>
                            </div>

                             

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="step_box steps2">
                            <div class="step_content2 pb-md-3">
                                <p class="black_color" data-aos-once="true" data-aos="fade-right">
                                    You can pay a monthly installment of at least ₹2000, or any higher multiples of ₹1000, 
                                    for 10 months using cash, online banking via Standing Instructions, Net-Banking, 
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
                    <div class="col-md-3">
                        <div class="step_box steps3">
                           
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/percent_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                             <div class="layer_img3">
                                    <img src="/assets/frontend/images/layer_1.png" class="d-block" alt="...">
                                </div>
                             <div class="step_content3 pt-md-5 pe-md-3 ps-md-4">
                                <p class="black_color" data-aos-once="true" data-aos="fade-left">
                                    Receive an exclusive discount of up to 75% of the value of your first installment when you redeem your plan.
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="step_box steps4">
                            <div class="step_content4 pb-1">
                                <p class="black_color" data-aos-once="true" data-aos="fade-left">
                                    Acquire your beloved Motiwala Jewels Gold and Diamonds jewellery using the entire redemption value.
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
   <div class="benefits_bgimage swing">
    <img src="/assets/frontend/images/benefits_bg.png" class="d-block" alt="..."></div>
<div class="row align-items-center">
    <div class="col-md-12"><h4 class="title_heading text-center black_color pb-lg-5 pb-md-4 pb-3 heading_font">Benefits Calculator</h4></div>
    <div class="col-md-5">
        
                <form>
                    <div class="row">

                        <div class="col-md-12">
                            <p>Slide or enter monthly installment amount</p>
                        </div>
                        <div class="col-md-12 mb-4">

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

                        <div class="col-md-12">
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
    <div class="col-md-7">
        <canvas id="myCanvas" width="350" height="350"></canvas>
    </div>
</div>

                
            </div>
        </div>


        <!--why choose us section start-->
        <section class="why_choose_section">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-md-4 pb-3  heading_font">Why Choose Us ?</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex gap-3" data-aos-once="true" data-aos="fade-up">                            
                            <img class="choose_img" src="/assets/frontend/images/best_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Best Price Guarantee</h5>
                                <p class="black_color">
                                We offer the best prices in the online Diamond Jewellery Business.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3 pb-md-4 pb-2" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/refer_icons.png" class="d-block w-100"
                                alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Refer and Earn</h5>
                                <p class="black_color">
                                   Refer your friend/family and earn 20% of your referral’s order’s Diamond Amount.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3 pb-md-4 pb-2" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/earnings_icons.png" class="d-block w-100"
                                alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Motiwala Treasure</h5>
                                <p class="black_color"> 
                                    A unique easy-pay system that gives you a 75% benefit on the value of your first installment when you redeem your plan.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3 pb-md-4 pb-2" data-aos-once="true" data-aos="fade-up">
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
                    
                    <div class="col-md-4">
                        <div class="d-flex gap-3" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/exchange_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Exquisite Jewellery Collection</h5>
                                <p class="black_color">
                                  Delivering top-notch quality jewellery with the latest designs at prices you can afford, we bring over a century of industry expertise right to you.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3" data-aos-once="true" data-aos="fade-up">
                            <img class="choose_img" src="/assets/frontend/images/warranty_icons.png"
                                class="d-block w-100" alt="...">
                            <div class="choose_content">
                                <h5 class="black_color">Transparent Pricing
                                </h5>
                                <p class="black_color">
                                    We believe in transparency, providing detailed breakdowns of costs and no hidden fees, so you know exactly what you're paying for.

                                </p>
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
                                Bangle,precious stones, and more crafted with precision and elegance to suit every occasion. Explore our diverse collections, from classic designs to contemporary styles, ensuring there's something special for everyone's taste and preferences.
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
                                It's our way of rewarding your commitment and dedication to our Motiwala Jewels Golden Treasure Purchase 
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
                                In addition to our special discount offer, our Motiwala Jewels Golden Treasure Purchase 
                                Plan comes with a range of other benefits tailored to enhance your overall experience. 
                                Firstly, you can expect top-notch service from our dedicated team who are committed to 
                                providing you with personalized assistance every step of the way. Moreover, we prioritize 
                                quality in every aspect of our service, ensuring that you receive jewellery crafted to the 
                                highest standards of craftsmanship and excellence. Furthermore, our prompt and attentive 
                                responses to any queries or concerns you may have reflect our commitment to your satisfaction 
                                and guarantee a seamless and enjoyable shopping experience with us. 
                                
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

    let total_amount = 100000;
    let discount_amount = 7500;
    
    // Function to generate data dynamically based on discount_amount and total_amount
    function generateData(discount_amount, total_amount) {
        return [
            {
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



      document.addEventListener('DOMContentLoaded', function() {
        const amountSpan = document.getElementById('amount');
        const amount10xSpan = document.getElementById('amount_10x');
        const amount13xSpan = document.getElementById('amount_13x');

        const amountPlusBtn = document.getElementById('amount_plus');
        const amountMinusBtn = document.getElementById('amount_minus');

        let currentAmount = 10000;


        function updateAmount() {
            amountSpan.textContent = '₹ ' + currentAmount.toLocaleString();
            amount10xSpan.textContent = '₹ ' + (currentAmount * 10).toLocaleString();
            amount13xSpan.textContent = '₹ ' + (currentAmount / 1000 * 10750).toLocaleString();

            total_amount = currentAmount * 10;
            discount_amount = (currentAmount / 1000 * 10750) - total_amount;

            updateDataAndRedraw();
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


    /* canvass graph open */

    console.log("vvvvvvvvvvvvvvvvvvvv KSF vvvvvvvvvvvvvvvvvvvv");

    var HoverPie = {};
    HoverPie.config = {
        canvasPadding: 1,
        hoverScaleX: 5.1,
        hoverScaleY: 1.1,
        labelColor: "#000",
        labelHoverColor: "rgba(255,255,255,1)",
        labelRadiusFactor: 0.66,
        labelFontFamily: "Quicksand",
        labelFontWeight: "bold",
        labelAlign: "center",
        labelFontSize: 14,
        sectorFillColor: "#000",
        sectorStrokeColor: "#000",
        sectorStrokeWidth: 2,
    };
    HoverPie.make = function ($canvas, data, config) {
        config = $.extend({}, HoverPie.config, config);

        var percent2radians = function (percent) {
            return percent * Math.PI * 2;
        };

        var ctx = $canvas[0].getContext("2d");
        var oX = ctx.canvas.width / 2;
        var oY = ctx.canvas.height / 2;
        var r = Math.min(oX, oY) - config.canvasPadding;
        var stage = new createjs.Stage("myCanvas");
        stage.enableMouseOver(20);

        var cumulativeAngle = 1.5 * Math.PI;

        for (var i = 0; i < data.length; i++) {
            var sector = new createjs.Shape();
            var container = new createjs.Container();
            container.name = container.id;

            // Draw the arc
            var sectorFillColor = data[i].fillColor || config.sectorFillColor;
            var sectorStrokeColor = data[i].strokeColor || config.sectorStrokeColor;
            sector.graphics
                .moveTo(oX, oY)
                .beginFill(sectorFillColor)
                .setStrokeStyle(config.sectorStrokeWidth)
                .beginStroke(sectorStrokeColor);

            var sectorAngle = percent2radians(data[i].percentage);
            sector.graphics.arc(
                oX,
                oY,
                r,
                cumulativeAngle,
                cumulativeAngle + sectorAngle
            );

            sector.graphics.closePath();

            container.addChild(sector);

            // Draw the label
            if (data[i].label) {
                // One for unhovered sectors
                var font =
                    config.labelFontWeight +
                    " " +
                    config.labelFontSize +
                    "px " +
                    config.labelFontFamily;
                var unhoverLabel = new createjs.Text(
                    data[i].label,
                    font,
                    config.labelColor
                );
                unhoverLabel.textAlign = "center";
                unhoverLabel.textBaseline = "bottom";

                // The label is to be placed such that the center of its baseline
                // is tangent to a circle of radius r*config.labelRadiusFactor
                // and a line drawn along the center of the sector
                var unhoverLabelRadius = r * config.labelRadiusFactor;
                var unhoverLabelAngle = cumulativeAngle + sectorAngle / 2.0;
                unhoverLabel.x =
                    oX + unhoverLabelRadius * Math.cos(unhoverLabelAngle);
                unhoverLabel.y =
                    oY + unhoverLabelRadius * Math.sin(unhoverLabelAngle);
                unhoverLabel.name = "label";

                // and one for hovered sectors

                container.addChild(unhoverLabel);
            }

            // Draw the description

            // reposition scale origin and draw origin
            container.regX = oX;
            container.regY = oY;
            container.x = oX;
            container.y = oY;

            cumulativeAngle += sectorAngle;
            stage.addChild(container);
            stage.update();
        } // percentages loop

        // This array tracks the currently-hovered pie sectors.
        // if it is empty, there are no sectors hovered.
        var hovers = [];

        var hover = function (ids) {
            //console.log(ids,stage.children);

            // This function is to be called with a list of stage IDs
            // it will revert any currently-hovered elements to their
            // original style, and apply hover style to the new set.

            // any ids in hovers that aren't in ids need to be unhovered
            var toUnhover = [];
            for (var i = 0; i < hovers.length; i++) {
                if (ids.indexOf(hovers[i]) == -1) {
                    // didn't find hover[i] in ids, so add to toUnhover
                    toUnhover.push(hovers[i]);
                }
            }
            for (var i = 0; i < toUnhover.length; i++) {
                var child = stage.getChildByName(toUnhover[i]);
                child.scaleX = 1;
                child.scaleY = 1;
            }

            // and ids in ids that aren't in hovers need to be hovered
            var toHover = [];
            for (var i = 0; i < ids.length; i++) {
                if (hovers.indexOf(ids[i]) == -1) {
                    // didn't find ids[i] in hovers, so add to toHover
                    toHover.push(ids[i]);
                }
            }
            for (var i = 0; i < toHover.length; i++) {
                var child = stage.getChildByName(toHover[i]);
                child.scaleX = config.hoverScaleX;
                child.scaleY = config.hoverScaleY;
            }

            hovers = ids;
            stage.update();
        };

        $canvas.mousemove(function (e) {
            var objs = stage.getObjectsUnderPoint(e.clientX, e.clientY);
            var ids = $.map(objs, function (e) {
                return e.parent.id;
            });

            // call hover() if ids does not match current hovers
            if (ids.length != hovers.length) {
                hover(ids);
                return;
            }
            for (var i = 0; i < hovers.length; i++) {
                if (ids[i] != hovers[i]) {
                    hover(ids);
                    return;
                }
            }
        });
    };

    var data = generateData(discount_amount, total_amount);
    HoverPie.make($("#myCanvas"), data, {});


  </script>
  
@endsection
