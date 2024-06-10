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
	<section class="pt-5 pb-5 terms_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-0 heading_font">Give Us Feedback</h4>
                </div>

				<div class="gives_feedback">
				     
                    @include('frontend.component.feedback_form')


                </div>

		
		
		  </div>
		</div>
	</section>
</main>

    <!-- -------------------- privacy content  end   ---------------- -->

    @endsection
