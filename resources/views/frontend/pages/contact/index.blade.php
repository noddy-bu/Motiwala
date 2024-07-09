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
		<div class="container py-md-5 py-3">
			<div class="row justify-content-between align-items-center">
				<div class="col-md-5 col-12">
					<h5 class="contact_form_heading black_color pb-md-3">Contact Us</h5>
					<h2 class="text-left pb-3 black_color contact_form_heading">We are here for you! <span class="d-block"> How can we help? </span> </h2>
					<!-- <p class="contact_form_text pb-md-3"></p> -->
					
					<div class="contact_info address">
						<i class="fa fa-location-dot"></i>
						<p class="mb-0">
							Shop No. 3, Fortune Tower, 337, Sir J J Road, Byculla Mumbai - 400 008. Maharashtra, India. 
						</p>
					</div>	 	
					<div class="contact_info number">
						<i class="fa fa-phone"></i>
						<a href="tel:+919920077780" class="text-decoration-none">+91 9920077780</a>
					</div>
					<div class="contact_info email_id">
						<i class="fa fa-envelope"></i>
						<a href="maitlto:motiwalajewels786@gmail.com" class="text-decoration-none">motiwalajewels786@gmail.com</a>
					</div>				
				</div>

				<div class="col-md-6 col-12 pt-md-0 pt-4">

					<h3 class="form_heading black_color mb-md-4 mb-3 mb-3">Send Message to Us</h3>
					<form id="add_contact_us_form" role="form" action="{{url(route('contact.create'))}}" method="post" class="contact_form" enctype="multipart/form-data">
						@csrf 
						<div class="col-12 mb-md-4 mb-3">
							<!-- <label class="pt-2 pt-md-3">Name* </label> -->
							<input type="text" class="form-control contact_name" name="name" placeholder="Enter Your Name*" wfd-id="id0" required="required">
						</div>
						<div class="row">
							<div class="col-md-6 col-12 mb-md-4 mb-3">
								<!-- <label class="pt-2 pt-md-3">Mobile Number* </label> -->
								<input type="tel" class="form-control contact_number" name="phone" placeholder="Enter Your Mobile Number*" wfd-id="id1" required="required">
							</div>

							<div class="col-md-6 col-12 mb-md-4 mb-3">
								<!-- <label class="pt-2 pt-md-3">Email Address* </label> -->
								<input type="text" class="form-control contact_email" name="email" placeholder="Enter Your Email Id*" wfd-id="id2" required="required">
							</div>
						</div>

						<div class="col-12">
							<!-- <label class="pt-2 pt-md-3">Message* </label> -->
							<textarea class="message mb-3"  
									rows="4"
									name="description"
									placeholder="Message*"
									required="required"></textarea>
						</div>

						<div class="text-md-start text-center
						">
							<div class="buttonclass1 mt-3 p-0">
								<button type="submit">SUBMIT <i class="las la-arrow-right"></i>
								</button>
							</div>
						</div>
					</form>
				</div> 
			</div>
		</div>
	</section>

</main>



@endsection

@section('component.scripts')
<script>
$(document).ready(function() {
    initValidate('#add_contact_us_form');
    $("#add_contact_us_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });

    var responseHandler = function(response) {
        $('input, textarea').val('');
        $("select option:first").prop('selected', true);
        setTimeout(function() {
            window.location.href = $('#baseUrl').attr('href') + '/thank-you';
        }, 2000);
    }
});
</script>
@endsection