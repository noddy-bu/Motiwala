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
	<section class="pt-5 information_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-left black_color pb-3 heading_font">Information</h4>
				</div>

				<div class="col-md-12">					
					<p>
            Introducing Motiwala Jewels Golden Treasure Purchase Plan – your smart, secure, 
            and easy way to own the stunning Motiwala Jewels Gold and Diamonds jewellery you love. 
            With this plan, you can get more jewellery for your money! How? Because when your plan matures, 
            Motiwala Jewels Gold and Diamonds will give you an extra discount as a special bonus. 
            It's a fantastic way to get the jewellery you want while saving money!
          </p>
				</div>

<div class="col-md-12">
					<h5 class="black_color pt-lg-4 pt-3 pb-3"><b>Golden Treasure  - </b></h5>
				</div>
				
				
        <div class="col-md-6">
          <div class="d-flex gap-4 pb-2 information_box" data-aos-once="true" data-aos="fade-up">
            <div class="step_box_icon">
              <div class="step_box_img">
                <img src="/assets/frontend/images/information_user.png" class="d-block" alt="...">
              </div>
            </div>
            <div class="choose_content">
              <p class="black_color">
                You can easily open a Motiwala Jewels Golden Treasure Purchase 
                Plan account either online through our website or app, or by simply 
                visiting our Motiwala Jewels Gold and Diamonds Pvt Ltd showroom.
              </p>
            </div>
          </div>
        </div>
		
		 <div class="col-md-6">
          <div class="d-flex gap-4 pb-2 information_box" data-aos-once="true" data-aos="fade-up">
            <div class="step_box_icon">
              <div class="step_box_img">
                <img src="/assets/frontend/images/information_card.png" class="d-block" alt="...">
              </div>
            </div>
            <div class="choose_content">
              <p class="black_color">
                You've got flexible payment options! Pay your monthly installments with cash, 
                card, or online banking using various methods like Standing Instruction (SI), 
                Net-banking, NEFT, and UPI or even post-dated cheques.
              </p>
            </div>
          </div>
        </div>
		
		 <div class="col-md-6">
          <div class="d-flex gap-4 pb-2 information_box" data-aos-once="true" data-aos="fade-up">
            <div class="step_box_icon">
              <div class="step_box_img">
                <img src="/assets/frontend/images/information_calender.png" class="d-block" alt="...">
              </div>
            </div>
            <div class="choose_content">
              <p class="black_color">
                Each month, make sure to pay a fixed installment amount by the due date for 10 months. 
                The minimum instalment value is INR 2000, but you can choose to pay more in multiples 
                of INR 1000 if you wish.
              </p>
            </div>
          </div>
        </div>
		
		 <div class="col-md-6">
          <div class="d-flex gap-4 pb-2 information_box" data-aos-once="true" data-aos="fade-up">
            <div class="step_box_icon">
              <div class="step_box_img">
                <img src="/assets/frontend/images/information_percent.png" class="d-block" alt="...">
              </div>
            </div>
            <div class="choose_content">
              <p class="black_color">
                Once you've completed 10 months of payments, you'll qualify for a special discount of 
                up to 75% of your first installment's value. That means more savings for you on the 
                jewellery you desire!
              </p>
            </div>
          </div>
        </div>

		<div class="col-md-12">
          <p class="py-lg-4 py-2">
              Please ensure to close your account within 400 days from the date you opened 
              your Motiwala Jewels Golden Treasure Purchase Plan account.
          </p>
          <p>For Example ( Only if all installments are paid on due date )</p>
        
		  <div class="information_tb">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Enrolment Date</th>
                <th scope="col">Maturity Date</th>
                <th scope="col">Instalment per month (in ₹)</th>
                <th scope="col">Discount on Jewellery purchase (in ₹)</th>
              <th scope="col">% of monthly installment</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1st Jan 2022</th>
                <td>1st Jan 2023</td>
                <td>4000</td>
                <td>3000</td>
              <td>75%</td>
              </tr>
            </tbody>
          </table>
        </div>
		  </div>
		
		</div>
		
		
		  </div>
		</div>
	</section>
</main>
@endsection