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
	<section class="pt-5 information_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-3 heading_font">Faq</h4>
				</div>
				<div class="col-md-12">
					<h5 class="black_color pb-2">
						<b>Queries on Enrolment</b>
					</h5>
					<p class="mb-0">1. Where can I buy ?</p>
					<p>
						You can find our exquisite collection of jewellery at our Store In Byculla Mumbai Maharashtra.
						Additionally, you can explore our wide range of designs and make purchases conveniently 
						through our secure online store from the comfort of your own home.
					</p>
					
					<p class="mb-0">2. What can I buy ?</p>
					<p>
						Discover a stunning array of options including Earrings, Necklaces, Ring, Bracelets,
						Bangle and more,precious stones, crafted with precision and elegance to suit every occasion.
						Explore our diverse collections, from classic designs to contemporary styles,
						ensuring there's something special for everyone's taste and preferences.
					</p>
					
					<p class="mb-0">3.Can I reedem and purchase before 11 months ?</p>
					<p>
						Certainly! Our flexible policy allows for redemption and purchase before the 11-month period ends. 
						Should you find the perfect piece earlier than expected, you're welcome to redeem your plan and 
						make your desired purchase at your convenience. This ensures that you have the freedom to acquire 
						your favorite jewellery whenever you're ready, giving you the ultimate flexibility and satisfaction 
						in your shopping experience with us.
						<br>
						Please check
					</p>
					
					<p class="mb-0">4. If I pay for 10 months, when will I get special discount ?</p>
					<p>
						Absolutely! Upon completing your 10 monthly payments, you'll become eligible for our special discount offer. 
						This means that once you've diligently paid your installments for the specified duration, 
						you'll unlock the opportunity to enjoy exclusive savings on your purchase. 
						It's our way of rewarding your commitment and dedication to our Motiwala Jewels Golden Treasurer Purchase 
						Plan. So, rest assured that your patience and loyalty will be duly recognized, and you'll be able to 
						avail yourself of the fantastic discount to make your jewellery purchase even more rewarding.
					</p>
					
					<p class="mb-0">5. What other benifits you get?</p>
					<p>
						In addition to our special discount offer, our Motiwala Jewels Golden Treasurer Purchase 
						Plan comes with a range of other benefits tailored to enhance your overall experience. 
						Firstly, you can expect top-notch service from our dedicated team who are committed to 
						providing you with personalized assistance every step of the way. Moreover, we prioritize 
						quality in every aspect of our service, ensuring that you receive jewellery crafted to the 
						highest standards of craftsmanship and excellence. Furthermore, our prompt and attentive 
						responses to any queries or concerns you may have reflect our commitment to your satisfaction 
						and guarantee a seamless and enjoyable shopping experience with us. 
						<br>
						Please check
					</p>
				
				</div>
			</div>
		</div>
	</section>
</main>
@endsection