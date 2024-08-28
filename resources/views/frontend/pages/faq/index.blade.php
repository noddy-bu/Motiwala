@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>


<main class="main" id="faq_page">



	<section class="faq_section_main">
            <div class="container">
                <h4 class="title_heading text-center black_color pb-2 pt-2 heading_font">Frequently Asked Questions</h4>
                
                <h4 class="enrollment_heading black_color mt-4 mb-3">Enrollment</h4>

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> 
                                What is the Golden Treasure 10+1 Plan?                            
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                The Golden Treasure Plan is the Gold & Diamond Jewellery Purchase Opportunity Plan. 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> 
                                Is Golden Treasure 10+1 Plan the same as an EMI (Equated Monthly Installment)
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                No. Our Golden Treasure 10+1 Plan is a savings plan, where you first save for {{ env('PLAN_1') }} 
                                and we pay 1 month installment On Behalf  then you can make a purchase of  
                                Jewellery after completion of the plan. 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> 
                                    Who is a Nominee? Who can I nominate? 
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            In the event of the death of the account holder, the person who was nominated by the 
                            account holder at the time of enrollment can utilize the plan. Nominee relationships 
                            can be Spouse, Father, Mother, Son or Daughter etc.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> 
                                How to enroll for Golden Treasure 10+1 Plan?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You can enroll for a Golden Treasure 10+1 Plan either at our store or online. Here's a
                                step-by-step guide to enroll online:
                                <ol class="enrollment_list">
                                    <li>Please click on the "Create Account" on our App or Website.</li>
                                    <li>Enter the mobile number and verify it.</li>
                                    <li>Please enter your Aadhar Number and nominee details.</li>
                                    <li>Choose the plan and select the amount for the plan.</li>
                                    <li>Verify Aadhaar card and proceed for E-sign. After that, you’ll be redirected to the payment gateway.</li>
                                    <li>Once the payment is successful, you will have started your Golden Treasure 10+1 Plan.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> 
                                Where can I find my Golden Treasure 10+1 Plan details after enrollment? 
                                What is the Golden Treasure 10+1 Plan passbook and how do I access it?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Once you create your account you'll have a user id and password and with that 
                                you can login to our website and see your plan details.                             
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> 
                                What is the minimum and maximum amount for Golden Treasure 10+1 Plan enrollment?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                The minimum amount is INR 3,000/- and for the maximum amount there is no limit.                             
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven"> 
                                Can I change the installment amount after Enrollment?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                No, you cannot change the amount after starting the Plan.                            
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEight">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight"> 
                                Can I cancel/refund the Golden Treasure 10+1 Plan?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Our Golden Treasure 10+1 Plan cancellation/refund policy is available only after 6 
                                installments and no extra benefits will be given.                               
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNine">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine"> 
                                Can I pay all the installments together and get a benefit?
                            </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                While you can make all the installment payments together, the plan benefits will 
                                only be issued on the plan maturity date, which is the 11th installment date.                               
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen"> 
                                Can I start multiple plans at a time?
                            </button>
                        </h2>
                        <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you can start multiple plans at a time.                              
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEleven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven"> 
                                Can I continue my Golden Treasure 10+1 Plan after {{ env('PLAN_1') }}?
                            </button>
                        </h2>
                        <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                After completion of the Golden Treasure plan you have to redeem it in a 12th month, 
                                in case if you don't claim it, the total amount you paid will get refunded in your 
                                account without extra benefit.                               
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwelve">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve"> 
                                Can I change the Nominee after enrollment?
                            </button>
                        </h2>
                        <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. Nominees can be changed after enrollment.                                
                            </div>
                        </div>
                    </div>


                    <h4 class="enrollment_heading black_color mt-4 mb-3">Payment</h4>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThirteen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen"> 
                                Now that I have enrolled, how and when should I make future payments?
                            </button>
                        </h2>
                        <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You can access your plan details (installment amount, due dates and payments made) 
                                on the website after Log in. This provides the due dates against each installment. 
                                The payment cycle for the next installment will be 1 month from the previous. 
                                Please click on "Pay Now" against the installment you need to pay for and proceed.                              
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFourteen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen"> 
                                Will I get a receipt / confirmation / online passbook after starting the Plan and after every installment?
                            </button>
                        </h2>
                        <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you will receive the confirmation via sms and email. Also you can see overall details in your Golden Treasure account.                              
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFifteen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen"> 
                                What are the payment options available?
                            </button>
                        </h2>
                        <div id="collapseFifteen" class="accordion-collapse collapse" aria-labelledby="headingFifteen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                We offer multiple payment options: UPI, Net banking, Credit & Debit Cards. 
                                Payments can also be made at our store.                               
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSixteen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen"> 
                                How can I see my payment status?
                            </button>
                        </h2>
                        <div id="collapseSixteen" class="accordion-collapse collapse" aria-labelledby="headingSixteen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You can access these details (installment amount, due date and payments made) 
                                in the Golden Treasure account.       
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeventeen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen"> 
                                Will I get a payment reminder / payment alert every month?
                            </button>
                        </h2>
                        <div id="collapseSeventeen" class="accordion-collapse collapse" aria-labelledby="headingSeventeen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you will get reminders on your registered mobile number and email address before 
                                the monthly due date.                            
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEighteen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEighteen" aria-expanded="false" aria-controls="collapseEighteen"> 
                                Can I opt for auto debit against every month installment?
                            </button>
                        </h2>
                        <div id="collapseEighteen" class="accordion-collapse collapse" aria-labelledby="headingEighteen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, we offer an auto-debit feature for Golden Treasure 10+1 Plan installment payments.	
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNineteen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNineteen" aria-expanded="false" aria-controls="collapseNineteen"> 
                                Can I change my monthly installment due date?                          
                            </button>
                        </h2>
                        <div id="collapseNineteen" class="accordion-collapse collapse" aria-labelledby="headingNineteen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">                                   
                                No, you can’t change your monthly installment due date after account creation.                                
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwenty">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwenty" aria-expanded="false" aria-controls="collapseTwenty"> 
                                What happens if a payment has been delayed?
                            </button>
                        </h2>
                        <div id="collapseTwenty" class="accordion-collapse collapse" aria-labelledby="headingTwenty"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You will not be eligible for the discount of that month if you miss paying the installments 
                                within the due date.                         
                            </div>
                        </div>
                    </div>


                    <h4 class="enrollment_heading black_color mt-4 mb-3">Redemption</h4>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentyOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyOne" aria-expanded="false" aria-controls="collapseTwentyOne"> 
                                How can I redeem my Golden Treasure 10+1 Plan?
                            </button>
                        </h2>
                        <div id="collapseTwentyOne" class="accordion-collapse collapse" aria-labelledby="headingTwentyOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Your Golden Treasure 10+1 Plan will be auto redeemed on the maturity date. You can claim it by visiting our store.                             
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentyTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyTwo" aria-expanded="false" aria-controls="collapseTwentyTwo"> 
                                What is the validity of my Golden Treasure 10+1 Plan? What happens if it is not used in the validity period?
                            </button>
                        </h2>
                        <div id="collapseTwentyTwo" class="accordion-collapse collapse" aria-labelledby="headingTwentyTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                After completion of Golden Treasure plan you have to redeem it in a 12th month, incase if you
                                don't claim it the total amount will get refunded in your account.                               
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentyThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyThree" aria-expanded="false" aria-controls="collapseTwentyThree"> 
                                What can I buy?
                            </button>
                        </h2>
                        <div id="collapseTwentyThree" class="accordion-collapse collapse" aria-labelledby="headingTwentyThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You can buy Gold & Diamond Jewellery.                  
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentyFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyFour" aria-expanded="false" aria-controls="collapseTwentyFour">
                                Where can I buy it?    
                            </button>
                        </h2>
                        <div id="collapseTwentyFour" class="accordion-collapse collapse" aria-labelledby="headingTwentyFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You can make a purchase at our store.           
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentyFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyFive" aria-expanded="false" aria-controls="collapseTwentyFive">                                  
                                Can I redeem my plan and purchase before {{ env('PLAN_1') }}?         
                            </button>
                        </h2>
                        <div id="collapseTwentyFive" class="accordion-collapse collapse" aria-labelledby="headingTwentyFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you can redeem your plan before {{ env('PLAN_1') }}.However, you will not be eligible 
                                for discounts.                
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentySix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentySix" aria-expanded="false" aria-controls="collapseTwentySix"> 
                                Can the validity of my Golden Treasure 10+1 Plan be extended?
                            </button>
                        </h2>
                        <div id="collapseTwentySix" class="accordion-collapse collapse" aria-labelledby="headingTwentySix"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                No, you can't extend your Golden Treasure plan                                      
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentySeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentySeven" aria-expanded="false" aria-controls="collapseTwentySeven"> 
                                Can I use the customized product?
                            </button>
                        </h2>
                        <div id="collapseTwentySeven" class="accordion-collapse collapse" aria-labelledby="headingTwentySeven"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you can customize the product.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwentyEight">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyEight" aria-expanded="false" aria-controls="collapseTwentyEight"> 
                                Can I start a new plan with the Golden Treasure 10+1 Plan?
                            </button>
                        </h2>
                        <div id="collapseTwentyEight" class="accordion-collapse collapse" aria-labelledby="headingTwentyEight"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                No.                                 
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

		
</main>
@endsection