@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

<!-- -------------------- Terms  start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>


<!-- -------------------- term content  start ---------------- -->  

<main class="main">
	<section class="pt-5 black_color terms_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="title_heading text-center black_color pb-0 heading_font">TERMS AND CONDITIONS</h4>
				   <h5 class="black_color text-center pb-md-4 pb-3">GOLDEN TREASURE JEWELLERY PURCHASE PLAN</h5>
                </div>

				<div class="col-md-12">
				    {{--@php echo html_entity_decode(get_settings('terms_content')) @endphp--}}	
								
					<h4>Plan</h4>	
					<p>The Golden Treasure Jewellery Purchase Plan (hereinafter “Golden Treasure” or the “Plan”) 
						offered by Motiwala Jewels Gold and Diamonds Pvt Ltd facilitates Customers 
						to purchase Gold and Diamonds Jewellery by making payments for the same over a ten month 
						period and the Customers will be entitled to avail certain discounts subject to these 
						Terms and Conditions.
					</p>

					<p>Under this Plan, the Customer has to pay 10 (Ten) fixed monthly installments of a 
						minimum of Rs. 2,000/- (Rupees Two Thousand only) or above (in multiples of one thousand). 
						During the course of the 10 (Ten) months, the Customer has to pay one instalment every month.
						More than one instalment in a single month will not be accepted.
					</p>

					<p>Customer will have to make the payment of the instalment on the Due Date. 
						For the purpose of this Plan, the Due Date shall be same date as the Enrollment Date 
						for the subsequent months. However, the Customer shall be provided with a grace 
						period of 7 (Seven) days in a month for payment of the instalment. 
						In the event the Customer fails to pay the instalment within the grace period, 
						the proportionate discount as offered herein shall be reduced.
					</p>

					<p>The Plan will mature after 366 (Three Hundred and Sixty Six) days from the Enrollment 
						Date and the Customers will be eligible to redeem by purchase of Jewellery from the 
						Company at the  Motiwala Jewels Gold and Diamonds Pvt Ltd store. For the purpose of 
						this Plan, the date of payment of first instalment shall be deemed as the Enrollment Date. 
						The Customer is mandatorily required to redeem his/her account before the 
						completion of 400 days from the Enrollment Date.
					</p>

					<p>The Customers would be eligible for a discount of 100% (Seventy Five percent) of one 
					   month’s instalment upon redemption, after the completion of 366 days from the Enrollment 
					   Date subject to the Customers having made the payment of all ten monthly installments.
					   If a Customer redeems before the completion of 366 (three hundred and sixty six) days 
					   but after the completion of 300 (Three Hundred) days, the Customer will be eligible 
					   for a discount ranging between 55% (Fifty Five percent) to 100% (Seventy Five percent) 
					   of one month instalment based on the number of days, and subject to the Customers 
					   having made the payment of all ten monthly installments. For redemption after 
					   completion of 180 (One Hundred and Eighty) days but before completion of 300 
					   (Three Hundred) days, Customer will be eligible for such prorated discount 
					   calculated based on the one month instalment, the number of days and the number 
					   of monthly installments paid.
					</p>

					<h4 class="pt-3">Pre-Close & Refund</h4>

					<p>The Customer will have the option to pre-close the Plan only if the Customer has paid 
						a minimum of six monthly installments and after completion of 180 days from the Enrollment Date. 
						In the event of such pre-closure, customer may purchase Jewellery at the Motiwala 
						Jewels Gold and Diamonds Pvt Ltd  Store equal to the value of the installments 
						accumulated in his/her account as on that day. Alternatively, Customer may seek 
						refund of the amount aggregating to the installments paid by the Customer until 
						the date of refund. The Customer will be provided with prorated discount voucher 
						that the Customer can utilize to purchase Jewellery from the Company for full 
						value of the installments paid. However, in the event the Customer has not paid 
						the requisite minimum six monthly installments, the Customer will not be eligible 
						for any discount/discount voucher.
					</p>

					<p>In case the Customer does not redeem within 400 days, he/she will be refunded 
						with the aggregate instalment amount paid by the Customer until the date of the refund. 
						A discount voucher for the applicable discount amount will be provided which can be 
						utilized only to purchase jewellery from the Company of a value that is equal to or 
						greater than the full value of installments paid.
					</p>

					<p>Refunds under the Plan, if any, will be made by way of cheque in the name of the 
						account holder as specified in the Enrollment Form or by online transfer to the 
						bank account as specified in the Enrollment Form, and no cash refund shall be permissible.
					</p>

					<p>Gold rate booked or charged on the invoice may vary city wise depending on the corporate 
						gold rate applied by the Company. The rate of gold shall be based on the Company’s rate 
						of gold prevailing on the date of purchase.
					</p>


					
					<p>Only individuals can enroll in to the Plan and Enrollment is not permissible for other 
						entities like companies, partnership firms or proprietorship concerns or Trusts or 
						Hindu Undivided Family (HUF) or NRI Customers. Minors may enroll only through their 
						natural guardians.
					</p>

					<p>Customers cannot enroll with his/her borrowed money.</p>

					<p>Enrollment may be through offline mode, i.e., at the Motiwala Jewels Gold and Diamonds Pvt Ltd 
						store, or online by registering on the Motiwala Jewels Gold and Diamonds Pvt Ltd website 
						<a href="https://www.motiwalajewels.in">https://www.motiwalajewels.in</a> or 
						Golden Treasure Jewellery Purchase  Mobile Application.
					</p>

					<p>The Customer is required to provide a copy of his/her photo identity (Pan Card) and 
						address proof documents like Aadhaar Card/Driving License/Voter ID/ Passport /Ration 
						Card any other document issued by the Government, bank account details, etc. 
						at the time of enrollment.
					</p>

					<p>The Customer is required to register at 
						<a href="https://www.motiwalajewels.in">https://www.motiwalajewels.in</a> 
						to manage his/her  Golden Treasure Purchase Plan Account. In case of any change in 
						contact or address details or any other details that the Customer may have furnished, 
						the Customer shall immediately contact customer care for effecting the changes. 
						The Customer can however change the address details through the Motiwala Jewels Gold 
						and Diamonds Pvt Ltd website 
						<a href="https://www.motiwalajewels.in">https://www.motiwalajewels.in</a> 
						or  Golden Treasure Jewellery Purchase Mobile Application as well, and any 
						such modification made shall be subject to the satisfaction and discretion of 
						Motiwala Jewels Gold and Diamonds Pvt Ltd. The Customer should especially ensure that 
						the name is as per the identity proof provided by the Customer, and not in any other name, 
						including nickname or short forms and the bank account details and other details as 
						provided in the Enrollment Form shall be accurate.
					</p>

					<p>Motiwala Jewels Gold and Diamonds Pvt Ltd  reserves right to verify the identity of 
						the Customer by means of SMS and/or OTP generation or by any other means at any time 
						including at the time of Enrollment and at the time of concluding the purchase and taking 
						the delivery of the jewellery. Motiwala Jewels Gold and Diamonds Pvt Ltd  also reserves 
						the right to verify the authenticity of the documents provided by the Customer.
					</p>

					<p>At the time of Enrollment, the Customer should ensure that, the Golden Treasure Jewellery 
						Purchase Plan Enrollment Form is signed in the space provided, physically or electronically, 
						as the case may be, accepting these terms and conditions.
					</p>
					
					<h4 class="pt-3">Payment</h4>
					<p>Payment of monthly instalment(s) may be made by cash, credit / debit cards, NEFT/ RTGS, 
						local cheques in favour of “MOTIWALA JEWELS GOLD AND DIAMONDS PVT LTD ” payable in the 
						city in where the Motiwala Jewels Gold and Diamonds Pvt Ltd  Store in which the account 
						was opened is located, Standing Instruction or Automated Clearing House. International 
						card for online payment will not be accepted. In case of cheque dishonour, the bank 
						charges shall be borne by the Customers. Payments can be made at any of the Motiwala 
						Jewels Gold and Diamonds Pvt Ltd  store or through the Motiwala Jewels Gold And 
						Diamonds Pvt Ltd website 
						<a href="https://www.motiwalajewels.in">https://www.motiwalajewels.in</a> 
						or Golden Treasure Jewellery Purchase Mobile Application. Motiwala Jewels Gold and 
						Diamonds Pvt Ltd shall not be responsible for any online payment failure and money
						being debited from the Customer’s account. Customers are requested to check with 
						their banks or other service providers for such payment failures. 
						It is the responsibility of the account holder to enter details correctly.
					</p>

					<p>Receipt for payment made by Automated Clearing House (“ACH”) or Standing Instruction (“SI”) 
						will be made only after clearance of payment. In case of ACH/SI enabled accounts, 
						the Plan cannot be closed prior to maturity date unless the account holder has 
						cancelled the ACH/SI by submitting the required forms to Titan. 
						The Customer may ask for a computerized receipt, from any Motiwala Jewels Gold and 
						Diamonds Pvt Ltd Store.
					</p>

					<p>The Company will not be responsible or liable to send reminders for payments.</p>

					<p>At the time of purchase of jewellery, the account holder has to personally come and 
						should produce a valid photo identity proof and PAN Card, if required under applicable law, 
						and effect the redemption of the installments paid towards purchase of jewellery. 
						The Company reserves the right to satisfy the identity of the Customer in any manner it deems fit.
					</p>

					<p>In addition to the gold and stone charges, all jewellery purchased under the Golden Treasure 
						Jewellery Purchase Plan  will be subject to making charges, waste charges, material charges, 
						Goods and Services Tax, or any other surcharges, levies as may be applicable/ prevailing 
						at the time of purchase.
					</p>

					<p>The Customer will have to purchase the jewellery for the total instalment amount paid 
						and partial purchase is not allowed.
					</p>

					<p>The Customer may appoint a nominee at the time of Enrollment upon submission of relevant documentation.
						In the event of death of the account holder, the amount is transferable by the Company only 
						to the person(s) whose nomination has been filled by the account holder in the Enrollment Form 
						at the time of opening the account subject to such nominee producing identity and address proof. 
						In case the account holder does not nominate any person, any claim(s) made by any other person(s) 
						on behalf of the account holder will not be entertained unless such person being a legal heir/duly 
						authorised person claiming the benefits under the Plan, shall produce below documents to the Company:
						<br>
						<Ol>
							<li>Death certificate of the deceased.</li>
							<li>Succession Certificate.</li>
							<li>NOC from other surviving legal heir for redemption.</li>
							<li>Indemnity undertaking to indemnify Titan from claims.</li>
							<li>Will (if any)</li>
							<li>Along with all other supporting documents and clarifications</li>
						</Ol>
						However, the decision of the Company shall be final on sufficiency of any document in all such cases 
						above and the same shall be binding upon the claimants.
					</p>

					<p>The Company reserves the right to alter, amend, add or delete part or whole of the privileges 
						of the Plan without prior notice to the account holder, as long as the same is not detrimental 
						to the interests of the account holder.
					</p>

					<p>The Company is the operator of this Plan and reserves the right to suspend the Plan at any time. 
						In any such event, the account holder may purchase any item at the Motiwala Jewels Gold And 
						Diamonds Pvt Ltd  Store equal to the value of the installments accumulated in his/her Golden 
						Treasure Jewellery Purchase Plan  account along with discounts accumulated, as on that day.
					</p>

					<p>The liability of the Company or its franchisee(s) or agents under Golden Treasure Jewellery 
						Purchase Plan  is limited to the extent of installments/advances paid by the account holder(s) 
						and the discount, as per the Plan and the terms and conditions contained herein, and thus 
						does not lead to any other assurance or warranty whatsoever by the Company.
					</p>

					<p>Any conditions that are not explicitly covered above would be the discretion of the Company at 
						the time of transaction/redemption. The decision of the Company in this regard would be deemed 
						as irrevocable and final.
					</p>

					<p>Disputes if any will be subject to the Courts in Bangalore jurisdiction only, to the exclusion 
						of any other court's jurisdiction.
					</p>

					<p>In case of any change in existing laws, rules, Acts, etc. by any regulatory authority, 
						the Company reserves the right to make such modifications/change/suspend/discontinue 
						the Plan suitable to the change of law and necessary requirements as per the same have 
						to be complied with by the account holder.
					</p>
					<br>
  	
                </div>

		
		
		  </div>
		</div>
	</section>
</main>

    <!-- -------------------- term content  end   ---------------- -->

    @endsection
