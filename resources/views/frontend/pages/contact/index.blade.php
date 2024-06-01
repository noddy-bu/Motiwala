@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



<!-- -------------------- contact banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>


<main class="main" id="contact_us_page">
	<!-- <section class="pt-5 contact_us_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-left black_color pb-3 heading_font">Contact Us</h4>
				</div>

		  </div>
		</div>
	</section> -->

	<section class="contact_form_section">
		<div class="container d-flex py-md-5 py-3 justify-content-between" >
			<div class="col-md-5 col-12">
				<h4 class="title_heading text-left black_color pb-3 heading_font contact_form_heading">Contact Us</h4>
				<p class="contact_form_text pb-md-3">We are here for you! How can we help?</p>
				<form action="" role="form" method="post" class="contact_form"> 
					<label class="pt-2 pt-md-3">Name* </label>
                    <input type="text" class="form-control contact_name" name="name" placeholder="Enter Your Name" wfd-id="id0" required="required">

					<label class="pt-2 pt-md-3">Mobile Number* </label>
					<input type="tel" class="form-control contact_number" name="mobile_number" placeholder="Enter Your Mobile Number" wfd-id="id1" required="required">

					<label class="pt-2 pt-md-3">Email Address* </label>
					<input type="text" class="form-control contact_email" name="mobile_number" placeholder="Enter Your Email Id" wfd-id="id2" required="required">

					<label class="pt-2 pt-md-3">Email Address* </label>
					<textarea class="message mb-3" 
							name="message" 
							rows="4" 
							placeholder="Message"
							required="required"></textarea>

					<button type="submit">SUBMIT</button>
				</form>
			</div>

			<div class="col-md-6 col-12">
				<img src="/assets/frontend/images/Contact_Us_Form_Ul_challenge.png" alt="" class="img-fluid">
				<div class="contact_info number">
					<i class="fa fa-phone"></i>
					<a href="tel:+919920077780" class="text-decoration-none">+91 9920077780</a>
				</div>
				<div class="contact_info email_id">
					<i class="fa fa-envelope"></i>
					<a href="maitlto:motiwalajewels786@gmail.com" class="text-decoration-none">motiwalajewels786@gmail.com</a>
				</div>
				<div class="contact_info address row">
					<div class="col-1">
						<i class="fa fa-location-dot"></i>
					</div>
					<div class="col-10 ps-2">
						<p class="">
							Register Office Address :- Shop No. 3, Fortune Tower, 337, Sir J J Road, Byculla Mumbai - 400 008. Maharashtra, India. 
						</p>
					</div>
				</div>	 	
			</div> 
		</div>
	</section>

</main>



@endsection