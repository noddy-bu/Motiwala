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
	<section class="pt-md-5 pt-4 information_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-3 heading_font">Faq</h4>
				</div>
				<div class="col-md-12">
					<h4 class="black_color text-center pb-2">
						Queries on Enrolment
					</h4>
					<p class="mb-0"><b>1. Where can I buy ?</b></p>
					<p>
						You can find our exquisite collection of jewellery at our Store In Byculla Mumbai Maharashtra.
						Additionally, you can explore our wide range of designs and make purchases conveniently 
						through our secure online store from the comfort of your own home.
					</p>
					
					<p class="mb-0"><b>2. What can I buy ?</b></p>
					<p>
						Discover a stunning array of options including Earrings, Necklaces, Ring, Bracelets,
						Bangle and more,precious stones, crafted with precision and elegance to suit every occasion.
						Explore our diverse collections, from classic designs to contemporary styles,
						ensuring there's something special for everyone's taste and preferences.
					</p>
					
					<p class="mb-0"><b>3. Can I reedem and purchase before 11 months ?</b></p>
					<p>
						Enjoy ultimate flexibility with our plan—redeem and purchase before the 11-month period ends. 
						Find your perfect piece early? Redeem your plan for a convenient purchase anytime. 
						Experience satisfaction with the freedom to acquire your favorite jewelry whenever you're ready.
						<br>
						Please check
					</p>
					
					<p class="mb-0"><b>4. If I pay for 10 months, when will I get special discount ?</b></p>
					<p>
						Complete 10 monthly payments to qualify for our exclusive discount offer. 
						Your dedication to our Golden Treasurer program will be rewarded with special savings on your purchase. 
						Enjoy the benefits of your commitment with this fantastic discount opportunity!
					</p>
					
					<p class="mb-0"><b>5. What other benifits you get? </b></p>
					<p>
						Our Golden Treasurer program offers more than just a discount. 
						Experience personalized assistance from our dedicated team throughout your journey. 
						Enjoy top-quality craftsmanship and excellent service standards with every piece. 
						Our prompt responses to your queries ensure a seamless and satisfying shopping experience. 
						<br>
						Please check
					</p>
				
				</div>
			</div>
		</div>
	</section>
</main>
@endsection