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
	<section class="instant_section py-md-5 py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color py-2 pb-md-2 heading_font">Instant Pay</h4>
				</div>

				<div class="col-md-12">
					<p class="text-center">Experience instant convenience with Instant Pay!
						<span class="d-lg-block">Easily settle your Motiwala Jewels Golden Treasure Purchase Plan installments hassle-free. </span>
						<span class="d-lg-block">Choose from a variety of online payment options including Debit card, Credit card,UPI, or Net Banking. </span>
						<span class="d-lg-block">Say goodbye to delays and embrace seamless transactions today! </span>
					</p>
				</div>

				<div class="col-md-12">
					<form action="" method="post" class="instant_pay" id="loginForm_instant_pay">
						<div class="form-group mt-md-4 mt-3 adhar_field">
                                {{-- <label class="pb-2 pb-md-3">Account Number* </label> --}}
								<label class="pb-2 pb-md-3">User ID* </label>
                                <input type="tel" class="form-control" name="phone" placeholder="Please Enter Your User ID" required/>
                            </div>


                            <div class="form-group mt-md-5 mt-3 adhar_field">
                                {{-- <label class="pb-2 pb-md-3">Mobile Number* </label> --}}
								<label class="pb-2 pb-md-3">Password* </label>
                                <input type="password" class="form-control" name="password" placeholder="Please Enter Your Password" required/>
                            </div>

                            <div class="form-group text-md-start text-center">
                                <div class="buttonclass1 mt60">
                                         <button type="submit">Proceed <i class="las la-arrow-right"></i></button>
                                </div>
                            </div>
				   </form>  
				</div>
		  </div>
		</div>
	</section>
</main>
@endsection

@section("page.scripts")
<script>

	initValidate('#loginForm_instant_pay');

	$(document).ready(function(){
		$('#loginForm_instant_pay').submit(function(e){
			e.preventDefault();

			let pay_installments =  "{{ route('pay-installments') }}";
			// let information = "{{ route('information') }}";
			let enrollment_page = "{{ route('account.new.enrollment.page') }}";

			var formData = $(this).serialize();
			var csrfToken = '{{ csrf_token() }}';

			$.ajax({
				url: "{{ route('customer.login') }}",
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						toastr.success(response.message, 'Success');
						setTimeout(function() {
						  let fragment = window.location.hash;
						  // Check if the fragment is "#instant-pay"
						//   if (fragment === "#instant-pay") {
							window.location.href = pay_installments;
						//   } else {
						// 	window.location.href = information;
						//   }
							
						}, 1000);
					} else if (response.status === 'incomplete') {
					  toastr.success(response.message, 'error');
						setTimeout(function() {
							window.location.href = enrollment_page;
						}, 1000);
					} else {
						toastr.error(response.message, 'Error');
					}
				},
				error: function(xhr, status, error) {
					toastr.error('Something went wrong please try again', 'Error');
				}
			});
		});

	});
  
  </script>
@endsection