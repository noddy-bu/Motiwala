@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

<!-- -------------------- Terms  start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.jpg" class="d-block w-100" alt="...">
</section>


<!-- -------------------- privacy content  start ---------------- -->  

<main class="main">
	<section class="pt-5 terms_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-0 heading_font">Old Scheme Closure</h4>
                </div>

				<div class="col-md-12">
				    <div class="md-title">
						<h4>
							For old golden harvest customers <span>
								(for all customers who have enrolled before 20th April
								2014)
							</span>
						</h4>
					</div>
					
					<div>
						<p>
						Titan Company Limited (TCL) formerly known as Titan industries Limited has been
						operating the Golden Harvest (11+1) and SwarnaNidhi Jewellery purchase schemes. In the newly
						enacted Companies Act, which became a law on 1st April 2014, certain new rules were introduced,
						specifically under Explanation to Section 2(1) (b) of the Companies (Acceptance of Deposit)
						Rules, 2014 which came into effect 1st April 2014, which appeared to bring such schemes also
						under the definition of Public Deposits. TCL is now constrained to comply with this new law
						immediately and is required to wind down the level of “deposits” (as these are termed now) in
						its current form. This means that TCL is constrained to stop accepting any further installments
						from the existing account holders, with immediate effect. To make it fair, practical and
						convenient to all its Golden harvest and Swarnanidhi account holders, TCL has designed a fair
						refund offer, the details of which are available with the stores. Please contact your nearest
						Tanishq store for closure details. The account holders are required to bring the original
						passbook and id proof for redemption of the account. Account holders cannot redeem the account
						without original passbook and id proof.
						</p>
					</div>
                </div>

				<div class="p-3 mb-2 text-white text-center" style="background-color:#c0af78;">
					<p>For any clarifications please contact your showroom where you opened your account or</p>

					<div>
						Call: <a href="tel:18009000000">1800 9000 000</a> | Email: <a href="mailto:xyz@gmail.com">xyz@gmail.com</a>
					</div>
				</div>

		
		
		  </div>
		</div>
	</section>
</main>

    <!-- -------------------- privacy content  end   ---------------- -->

    @endsection
