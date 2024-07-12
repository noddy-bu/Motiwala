@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>


<main class="main">



	<section class="faq_section">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-2 pt-2 heading_font">Frequently Asked Questions</h4>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
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
                    <div class="accordion-item">
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
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> 
                                    Can I redeem and purchase before 11 months ? 
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Enjoy ultimate flexibility with our plan—redeem and purchase before the 11-month period ends. 
                                Find your perfect piece early? Redeem your plan for a convenient purchase anytime. 
                                Experience satisfaction with the freedom to acquire your favorite jewelry whenever you're ready.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> 
                                If I pay for 10 months, when will I get special discount ? </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Complete 10 monthly payments to qualify for our exclusive discount offer. 
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
                                Our prompt responses to your queries ensure a seamless and satisfying shopping experience. 
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

		
</main>
@endsection