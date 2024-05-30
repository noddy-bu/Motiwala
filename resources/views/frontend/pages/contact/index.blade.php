@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.jpg" class="d-block w-100" alt="...">
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
		<div class="container row mx-md-auto py-md-5 py-3 bg-light justify-content-between" >
			<div class="col-md-5 col-12">
				<h4 class="title_heading text-left black_color pb-3 heading_font contact_form_heading">Contact Us</h4>
				<span class="contact_form_text pb-md-3">We are here for you! How can we help?</span>
				<form action="" role="form" method="post" class="contact_form"> 
					<input class="form-control contact_name" 
							type="text" 
							name="name" 
							required="required"
							placeholder="Enter your name">

					<input class="form-control contact_email" 
							type="text" 
							name="email" 
							required="required"
							placeholder="Enter your email address">

					<textarea class="form-control message" 
							name="message" 
							rows="4" 
							placeholder="Go ahead we are listening"
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
				<div class="contact_info address">
					<i class="fa fa-location-dot"></i>
					<a href="" class="text-decoration-none">Lorem ipsum doller te amirates...</a>
				</div>			
			</div>
		</div>
	</section>

</main>



@endsection