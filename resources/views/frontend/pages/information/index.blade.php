@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

@php
$plan_Details = DB::table('plans')
    ->where('status', 1)
    ->get(['minimum_installment_amount', 'plan_start_date', 'plan_end_date', 'id']);
@endphp

<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>


<main class="main">
	<section class="py-md-5 py-4 information_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-left black_color pb-0 heading_font">Information</h4>
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
					<h5 class="black_color py-lg-3 py-3 pt-1"><b>Golden Treasure  - </b></h5>
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
                You can easily open a Motiwala Jewels Golden Treasure Purchase 
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
                <img src="/assets/frontend/images/information_calender.svg" class="d-block" alt="...">
              </div>
            </div>
            <div class="choose_content">
              <p class="black_color">
                Each month, make sure to pay a fixed installment amount by the due date for {{ env('PLAN_1') }} . 
                The minimum installment value is INR 3000, but you can choose to pay more in multiples 
                of INR 1000 if you wish.
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
                Once you've completed {{ env('PLAN_1') }} of payments, you'll qualify for a special discount of 
                up to 100% of your first installment's value. That means more savings for you on the 
                jewellery you desire!
              </p>
            </div>
          </div>
        </div>


        <div class="col-md-12">
          <p class="py-lg-2 py-0">
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
                <th scope="col">Installments per month (in ₹)</th>
                <th scope="col">Discount on Jewellery purchase (in ₹)</th>
                <th scope="col">% of your first installment value</th>
              </tr>
            </thead>
            <tbody>
             {{--@foreach ($plan_Details as $row)
                <tr>
                  <td>{{ custom_date_change($row->plan_start_date) }}</td>
                  <td>{{ custom_date_change($row->plan_end_date) }}</td>
                  <td>{{ (int) $row->minimum_installment_amount }}</td>
                  <td>{{  $row->minimum_installment_amount * 100 / 100 }}</td>
                <td>100%</td>
                </tr>
              @endforeach--}}
              <tr>
                <td>1st Jan 2024</td>
                <td>1st Jan 2025</td>
                <td>3000</td>
                <td>3000</td>
                <td>100%</td>
              </tr>
            </tbody>
          </table>
        </div>
		  </div>
		
		</div>


        <div class="col-md-12">
					<h5 class="black_color py-lg-3 py-3 pt-lg-5 pt-1"><b>Golden Fortune  - </b></h5>
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
                <img src="/assets/frontend/images/information_calender.svg" class="d-block" alt="...">
              </div>
            </div>
            <div class="choose_content">
              <p class="black_color">
                Each month, make sure to pay a fixed installment amount by the due date for {{ env('PLAN_2') }} . 
                The minimum installment value is INR 3000, but you can choose to pay more in multiples 
                of INR 1000 if you wish.
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
                Once you've completed {{ env('PLAN_2') }} of payments, you'll qualify for a special discount of 
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
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Enrolment Date</th>
                <th scope="col">Maturity Date</th>
                <th scope="col">Installments per month (in ₹)</th>
                <th scope="col">Gold Reserved</th>              
              </tr>
            </thead>
            <tbody>
              {{-- @foreach ($plan_Details as $row)
                <tr>
                  <td>{{ custom_date_change($row->plan_start_date) }}</td>
                  <td>{{ custom_date_change($row->plan_end_date) }}</td>
                  <td>{{ (int) $row->minimum_installment_amount }}</td>
                  <td>{{  $row->minimum_installment_amount * 100 / 100 }}</td>
                </tr>
              @endforeach --}}
              <tr>
                <td>1st Jan 2024</td>
                <td>1st Jan 2025</td>
                <td>3000</td>
                <td>100%</td>
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