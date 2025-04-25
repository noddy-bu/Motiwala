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
        <section id="golden_fortune" class="py-md-5 py-4 information_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-left black_color pb-4"><b>Golden Fortune</b></h4>
                    </div>


                    <div class="col-md-3">
                        <div class="d-flex gap-lg-3 gap-2 pb-md-2 pb-1 information_box">
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/user_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                            <div class="choose_content">
                                <p class="black_color">
                                    You can easily open a Motiwala Jewels Golden Fortune Purchase
                                    Plan account either online through our website or app, or by simply
                                    visiting our Motiwala Jewels Gold and Diamonds Pvt Ltd showroom.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-lg-3 gap-2 pb-md-2 pb-1 information_box">
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/information_card.svg" class="d-block" alt="...">
                                </div>
                            </div>
                            <div class="choose_content">
                                <p class="black_color">
                                    You've got flexible payment options! Pay your monthly installments with cash,
                                    card, or online banking using various methods like Standing Instruction (SI),
                                    Net-banking, NEFT, and UPI.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-lg-3 gap-2 pb-md-2 pb-1 information_box">
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/information_calender.svg" class="d-block"
                                        alt="...">
                                </div>
                            </div>
                            <div class="choose_content">
                                <p class="black_color">
                                    Your golden journey starts here! Contribute for just 12 months with a minimum of
                                    ₹10,000. Want to invest more? Add in multiples of ₹1,000 anytime! Each payment locks in
                                    gold at the 22K rate of that day. And the cherry on top? Enjoy 0% making charges on your
                                    accumulated gold at the end of the plan. Start today and let your fortune shine!
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-lg-3 gap-2 pb-md-2 pb-1 information_box">
                            <div class="step_box_icon">
                                <div class="step_box_img">
                                    <img src="/assets/frontend/images/percent_icon.png" class="d-block" alt="...">
                                </div>
                            </div>
                            <div class="choose_content">
                                <p class="black_color">
                                    Once you've completed 12 of payments, you'll qualify for a special discount of
                                    up to 100% of your first installment's value. That means more savings for you on the
                                    jewellery you desire!
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <p class="py-lg-2 py-0">
                            Please ensure to close your account within 400 days from the date you opened
                            your Motiwala Jewels Golden Fortune Purchase Plan account.
                        </p>
                        <p>For Example ( Only if all installments are paid on due date )</p>

                        <div class="information_tb">


                            @include('frontend.component.gold_rate_table')


                            <div class="col-md-12">
                                <div class="buttonclass float_rights mt-md-4 mt-3">
                                    <a href="/account/onlineenrollment">Start Your Plan Now<i
                                            class="las la-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </section>


    </main>
@endsection
