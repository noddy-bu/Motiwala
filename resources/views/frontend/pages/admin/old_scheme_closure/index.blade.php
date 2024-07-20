@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

<!-- -------------------- Terms  start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>


<!-- -------------------- privacy content  start ---------------- -->  

<main class="main">
	<section class="pt-5 inner_sectionpadd old_sheme_closure">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-0 heading_font">Old Scheme Closure</h4>
                </div>
				<div>
					<div class="text-center mb-3">
						<a class="text-decoration-none text-dark" href="/termsofuse">Terms Of Use</a> | 
						<a class="text-decoration-none text-dark" href="/privacy-policy">Privacy Policy</a> | 
						<a class="text-decoration-none text-dark" href="{{ url(route('feedback')) }}">Give Us Feedback</a>
					</div>
					<p class="text-center"> 
						Copyright © 2024 Under Motiwala Jewels Gold and Diamonds Pvt Ltd. Company. 
						All Rights Reserved. No imagery or logos contained within this site may be used without the express permission of Motiwala Jewels Gold And Diamonds Pvt Ltd Company
					</p>
				</div>	
		
		  </div>
		</div>
	</section>
</main>

    <!-- -------------------- privacy content  end   ---------------- -->

    @endsection
