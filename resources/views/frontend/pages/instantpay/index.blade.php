@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.jpg" class="d-block w-100" alt="...">
</section>


<main class="main">
	<section class="instant_section pt-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-3 heading_font">Instant Pay</h4>
				</div>

				<div class="col-md-12">
					<p class="text-center">Experience instant convenience with Instant Pay!
						<span class="d-lg-block">Easily settle your Motiwala Jewels Golden Treasure Purchase Plan installments hassle-free. </span>
						<span class="d-lg-block">Choose from a variety of online payment options including Debit card, Credit card,UPI, or Net Banking. </span>
						<span class="d-lg-block">Say goodbye to delays and embrace seamless transactions today! </span>
					</p>
				</div>

				<div class="col-md-12">
					<form action="" method="post" class="instant_pay">
						<div class="form-group mt-4 adhar_field">
                                <label class="pb-3">Account Number* </label>
                                <input type="tel" class="form-control" name="mobile_number" placeholder="Please Enter Your Account Number"/>
                            </div>


                            <div class="form-group mt-5 adhar_field">
                                <label class="pb-3">Mobile Number* </label>
                                <input type="tel" class="form-control" name="mobile_number" placeholder="Please Enter Your Mobile Number"/>
                            </div>

                            <div class="form-group text-center">
                                <div class="buttonclass1 mt60">
                                         <button type="button">Proceed <i class="las la-arrow-right"></i></button>
                                </div>
                            </div>
                      
				   </form>  
				</div>
		  </div>
		</div>
	</section>
</main>
@endsection