 
<!-- {{-- @php
    $data = [
        'user' => (object) [
            'id' => '12',
            'name' => 'abcd',
            'email' => 'emai@test.com',
            'phone' => '12345678',
            'plan_name' => 'Sample Plan',
            'ulp_id' => '12',
            'installment_amount' => '123',
        ],
        'user_detail' => (object) [
            'pan_number' => '1234567890',
            'flat_no' => '1',
            'street' => '1',
            'locality' => '1',
            'city' => '1',
            'state' => '1',
            'pincode' => '1',
            'aadhar_number' => '12345',
            'pan_number' => '123',
            'address' => 'fkdsjfljsdflj sasdaklfjsdlfjljsadf dsfjadjsf',
        ],
        'plan' => (object) [
            'installment_period' => '123',
        ],
    ];

@endphp--}} -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details PDF</title>
    <style>

        @font-face {
            font-family: 'Quicksand';
            src: url('http://127.0.0.1:8000/assets/frontend/fonts/116af611cbcd9e4bada60b4e700430c1.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

         body {
            font-family: 'Quicksand', sans-serif;
            padding-bottom: 80px;
        }

          .text_fonts div
        {
            font-size:14px;
        }

        .text_fonts li
        {
            font-size:14px;
        }
        .table-bordered 
        {
            width:100%;
        }
.table-bordered th,td
{
    font-size:14px;
    border-left:1px solid #ccc;
    border-bottom:1px solid #ccc;
    padding:8px 0px 8px 15px!important;
}


    </style>
</head>
<body>
    <h1 style="text-align:center; font-size:26px; padding-bottom:20px;">{{ ucfirst($data['plan']->name) }} Plan Customer Application</h1>
    <p><b>Application Number: {{ application_no($data['user']->id) }}</b></p>


    <div style="width:100%;">
    <div style="width:25%; float:left;"><b>Account Holder Name:</b></div>
    {{-- <div style="width:75%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']->first_name }} {{ $data['user']->last_name }}</div> --}}
    <div style="width:75%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']->fullname }}</div>
</div>
<br>

    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:25%; float:left;"><b>Enricle No:</b></div>
    <div style="width:75%; float:left; border-bottom:1px solid #ccc;">{{ ulp_id($data['user']->id) }}</div>
</div>
 <div style="width:50%; ">
    <div style="width:20%; float:left;"><b>Email ID:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']->email }}</div>
</div>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:20%; float:left;"><b>Contact Number:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']->phone }}</div>
</div>
<br>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:22%; float:left;"><b>Customer Address:</b></div>
    <div style="width:78%; float:left; border-bottom:1px solid #ccc;">
        {{-- {{ $data['user_detail']->flat_no }} {{ $data['user_detail']->street }}
        {{ $data['user_detail']->locality }} {{ $data['user_detail']->city }}
        {{ $data['user_detail']->state }} {{ $data['user_detail']->pincode }} --}}
        {{ $data['user_detail']->address; }}
    </div>
</div>

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px"><b>Account Information:</b></div>
</div>


    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:57%; float:left;"><b>Installment Amount (Rs.):</b></div>
    <div style="width:43%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']->installment_amount }}</div>
</div>
 <div style="width:50%; ">
    <div style="width:40%; float:left;"><b>Scheme Duration:</b></div>
    <div style="width:60%; float:left; border-bottom:1px solid #ccc;">{{ (int) $data['plan']->installment_period }} Months</div>
</div>

 <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:25%; float:left;"><b>Adhaar No:</b></div>
    <div style="width:75%; float:left; border-bottom:1px solid #ccc;">{{ $data['user_detail']->aadhar_number }}</div>
</div>
 <div style="width:50%; ">
    <div style="width:32%; float:left;"><b>Pan Card No:</b></div>
    <div style="width:68%; float:left; border-bottom:1px solid #ccc;">{{ $data['user_detail']->pan_number }}</div>
</div>


 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px;"><b>Nominee Details:</b></div>
</div>


 <div style="width:100%; padding-top:15px;">
    <div style="width:18%; float:left;"><b>Nominee Name:</b></div>
    <div style="width:82%; float:left; border-bottom:1px solid #ccc;">{{ !empty($data['user_detail']->nominee_name) ? $data['user_detail']->nominee_name : 'NA' }}</div>
</div>
<br>

    <div style="width:55%; clear:both; padding-top:15px;">
    <div style="width:70%; float:left;"><b>Relationship with account holder:</b></div>
    <div style="width:30%; float:left; border-bottom:1px solid #ccc;">{{ !empty($data['user_detail']->nominee_relation) ? $data['user_detail']->nominee_relation : 'NA' }}</div>
</div>
 <div style="width:45%; ">
    <div style="width:42%; float:left;"><b> Contact Number:</b></div>
    <div style="width:58%; float:left; border-bottom:1px solid #ccc;">{{ !empty($data['user_detail']->nominee_phone) ? $data['user_detail']->nominee_phone : 'NA' }}</div>
</div>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:23%; float:left;"><b>Customer Address:</b></div>
    <div style="width:77%; float:left; border-bottom:1px solid #ccc;">{{ !empty($data['user_detail']->nominee_address) ? $data['user_detail']->nominee_address : 'NA' }}</div>
</div>



<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:30px;">
    <div style="margin-bottom:0px"><b>Purpose:</b> Both plans facilitate the purchase of gold and diamond jewellery by making payments over a specified period and offer certain discounts.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Eligibility:</b> Both plans are available only to Indian citizens who have attained the age of majority. Enrollment is not permitted for entities like companies, partnership firms, trusts, Hindu Undivided Families (HUF), or NRIs.

</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Payment Methods:</b> Payments for both plans can be made through cash, credit/debit cards, NEFT/RTGS, or local cheques. International cards/transfers are not accepted.</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Enrolment Requirements:</b> Customers must provide photo ID (e.g., PAN card) and address proof (e.g., Aadhaar card.) at the time of enrollment. Enrollment can be done either offline at the store or online through the respective websites/apps.</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Redemption:</b> Both plans require the customer to make a purchase or take delivery of the jewellery within a certain period after the completion of the payment term. Golden Fortune requires redemption within 365 days, while Golden Treasure requires redemption before 400 days.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>No Cash Refunds:</b> Neither plan offers cash refunds. Refunds, if any, are provided via
cheque or online transfer.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Discounts and Offers:</b> Discounts are available based on the completion of the payment term. Both plans provide discounts on making charges utilized for jewellery purchases.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Partial Purchases:</b> Both plans mandate that the customer must purchase jewellery for the total amount accumulated. Partial purchases are not allowed.</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Applicable Charges:</b> All jewellery purchased under the Golden Treasure and Golden Fortune Jewellery Purchase Plan will be subject to applicable charges, including making charges, wastage, material charges, gold and stone charges, Goods and Services Tax (GST), and any other surcharges or levies prevailing at the time of purchase</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Nomination:</b> The Customer may appoint a nominee at the time of Enrollment upon submission of relevant documentation. In the event of death of the account holder, the amount is transferable by the Company only to the person(s) whose nomination has been filled by the account holder in the Enrollment Form at the time of opening the account subject to such nominee producing identity and address proof. In case the account holder does not nominate any person, any claim(s) made by any other person(s) on behalf of the account holder will not be entertained unless such person being a legal heir/duly authorised person claiming the benefits under the Plan, shall produce below documents to the Company:</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:10px; padding-left:30px;">
    <div style="margin-bottom:0px">
        1. Death certificate of the deceased. </br>
        2. Succession Certificate</br>
        3. NOC from other surviving legal heir for redemption.</br>
        4. Indemnity undertaking to indemnify Motiwala Jewels from claims.
5. Will (if any)</br>
6. Along with all other supporting documents and clarifications
    </div>
</div>


<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px">However, the decision of the Company shall be final on sufficiency of any document in all such cases above and the same shall be binding upon the claimants.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Customer Responsibility:</b>Customers are responsible for keeping their contact and address details updated and ensuring the accuracy of their payment details.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Suspension and Modifications:</b> Both plans reserve the right to suspend, modify, or discontinue the plan without prior notice. Any changes due to regulatory requirements will be communicated accordingly.</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>Dispute Resolution:</b> Disputes arising from the plans are subject to specific jurisdiction: Mumbai for Golden Fortune and Golden Treasure.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px"><b>SMS and OTP:</b> Motiwala Jewels Gold and Diamonds Pvt Ltd reserves right to verify the identity of the Customer by means of SMS and/or OTP generation or by any other means at any time including at the time of Enrollment and at the time of concluding the purchase and taking the delivery of the jewellery. Motiwala Jewels Gold and Diamonds Pvt Ltd also reserves the right to verify the authenticity of the documents provided by the Customer.</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:30px;">
    <div style="margin-bottom:0px; font-size:22px"><b>Terms & Condition</b></div>
</div>


<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px">The Motiwala Jewels Golden Fortune Plan offered by Motiwala jewels Gold and
Diamonds Pvt Ltd facilitates customers to purchase Motiwala Jewels by making monthly
payments over a elventh-month period and avail certain special discounts on making
charges subject to these Terms and Conditions:</div>
</div>
<div style="width:100%; clear:both; margin-bottom:0px;padding-top:0px;">
    <div class="text_fonts" style="margin-bottom:0px">

    <ul style="list-style: decimal;">
        <li style="padding-bottom:15px;">The monthly payment amount is not subject to change once it has been fixed at
the time of enrolment, and the customer shall make the payment of the same
amount as the monthly amount, every month for a period of eleven months from
the enrolment date.</li>

        <li style="padding-bottom:15px;">No payments shall be accepted beyond the completion of 365 days from the
enrollment date.</li>

        <li style="padding-bottom:15px;">The payment of the monthly amount must be made within three (03) days from
the due date.</li>

        <li style="padding-bottom:15px;">In the event of any default in making the payments as mentioned herein, the
customer shall not be eligible to pay the same at a later date or club with any
other payments for subsequent months. It shall be considered as a missed
monthly payment.
</li>

        <li style="padding-bottom:15px;">Against each monthly payment made, Motiwala Jewels will reserve/accumulate
the equivalent grams of gold for future purchase by the customer as per the
prevailing store gold rate of the day for 22 Karat gold on which the monthly
payment is made.</li>

        <li style="padding-bottom:15px;">Under this Plan, the customer will be eligible for the purchase of 22 Karat gold
jewellery for the equivalent grams accumulated during the tenure of the Plan and
also be eligible for discount on making charges on purchase of jewellery in
accordance with the number of monthly payments made, as per the illustrative
table below:</li>



<div class="" style="text-center; font-size:18px; padding-bottom:10px; padding-top:10px;"><b>Example - Monthly Savings: Rs. 10,000/- and above</b></div>
<table class="table table-bordered" style="margin-bottom:20px; border:1px solid #ccc;">
								<tbody><tr class="table-light">
										<th class="col-md-2">Gold Rate</th>
										<th class="col-md-2">Month</th>
										<th class="col-md-2">Monthly Payment (in INR)</th>
										<th class="col-md-2">Equivalent gold in grams accumulated</th>
								
									</tr>
									<tr class="table-light">
										<td>6580</td>
										<td>1</td>
										<td>10,000</td>
										<td>1.519</td>
									</tr>
									<tr class="table-light">
										<td>6633</td>
										<td>2</td>
										<td>10,000</td>
										<td>1.507</td>
									</tr>
									<tr class="table-light">
										<td>6638</td>
										<td>3</td>
										<td>10,000</td>
										<td>1.506</td>
									</tr>
									<tr class="table-light">
										<td>6740</td>
										<td>4</td>
										<td>10,000</td>
										<td>1.483</td>
									</tr>
									<tr class="table-light">
										<td>6465</td>
										<td>5</td>
										<td>10,000</td>
										<td>1.546</td>
									</tr>
									<tr class="table-light">
										<td>6575</td>
										<td>6</td>
										<td>10,000</td>
										<td>1.520</td>
									</tr>
									<tr class="table-light">
										<td>6570</td>
										<td>7</td>
										<td>10,000</td>
										<td>1.522</td>
									</tr>
									<tr class="table-light">
										<td>6500</td>
										<td>8</td>
										<td>10,000</td>
										<td>1.538</td>
									</tr>
									<tr class="table-light">
										<td>6550</td>
										<td>9</td>
										<td>10,000</td>
										<td>1.526</td>
									</tr>
									<tr class="table-light">
										<td>6600</td>
										<td>10</td>
										<td>10,000</td>
										<td>1.515</td>
									</tr>
								</tbody></table>


                                <div >
                                    </div>
<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:5px; padding-bottom:20px;">
    <div style="margin-bottom:0px"><b>Illustration:-</b>  If a customer pays Rs. 10.000/- every month for 11 months with gold rate as per the illustrative example table given above, the customer accumulates a total equivalent weight of 15.182 grams of gold as per the gold rate on the date of payment. At the time of purchase. The customer can buy jewellery of minimum 15.182 grams of gold accumulated and be eligible for discount on Making Charges of the selected product For the additional grammage in case of purchase over and above 15.182 gram, ' store offer shall be applicable.
                                
</div>
</div>

        <li style="padding-bottom:15px;">The customers are mandatorily required to make the purchase and take delivery
of the jewellery against the equivalent grams of gold accumulated within the
completion of 365 days from the enrolment date. In the event the customer does
not conclude the purchase and take delivery of jewellery within the said time, the
customer will be invoiced 22 Karat gold coin(s) equivalent to the nearest lower
round figure (e.g., 16.06 grams will be taken as 16 grams or 18.82 grams will be
taken as 18 grams) of equivalent grams of gold accumulated during the tenure
and the equivalent value of fractional grams of gold on the date of redemption will
be refunded to the bank account provided at the time of enrolment. Accordingly,
the account under this Plan shall stand closed. Motiwala Jewels will deliver the
Gold coin to the address provided by the customer in the enrollment form. In the
event the product is returned to Motiwala Jewels undelivered, Motiwala Jewels
will keep the custody of the said gold coin(s) for a period of Six (6) months from
the end of the 365th day for the customer to collect it. Thereafter, the customer
will have no claims whatsoever in this regard.</li>

        <li style="padding-bottom:15px;">The customer will have to purchase the jewellery for the total quantity of the
equivalent grams of gold accumulated and partial purchase is not allowed. The
customer shall be eligible for availing the applicable discount on making charges
only on the value of the equivalent grams of gold accumulated. In cases of
additional purchase, any running offer at the stores shall be applicable on the
differential weight.</li>

        <li style="padding-bottom:15px;">The customer who wishes to discontinue this Plan prior to the completion of 6
months from the enrolment date will have the option to purchase jewellery for the
equivalent weight accumulated during the tenure of the Plan. However, the
customer will not be eligible for any discount.
</li>

        <li style="padding-bottom:15px;">The special discount availed pursuant to the Plan cannot be linked or clubbed
with any existing offers or any other plans offered by the Company and is not
transferable under any circumstance.</li>

        <li style="padding-bottom:15px;">This Plan cannot be redeemed against advance booking and customer orders.</li>


        <div style="padding-bottom:10px; padding-top:10px;"><b>Additional Terms and Conditions</b></div>
        <li style="padding-bottom:15px;">Only Indian citizens who have attained the age of majority and are competent to
contract shall be eligible under this Plan, and NRIs and other entities like
companies, partnership firms or proprietorship concerns or Trusts or Hindu
Undivided Family (HUF) cannot participate in the same</li>

        <li style="padding-bottom:15px;">The customer will be required to fill an enrolment form and submit necessary
documents at the time of enrolment. Bank Account details and PAN card (for
monthly payment value greater than Rs 10000/-) are mandatory for enrolment
under this Plan.</li>

        <li style="padding-bottom:15px;">At the time of enrolment, the customer should ensure that the enrolment form is
signed in the space provided, physically or electronically, as the case may be,
accepting these Terms and Conditions. Notwithstanding the foregoing, as soon
as the customer effects the first transaction under this Plan, it shall be deemed
that the customer has accepted these Terms and Conditions.</li>

        <li style="padding-bottom:15px;">.International card/transfers for online payment will not be accepted. Payments
can be made at the Motiwala Jewels stores or through the App as may be
applicable.
</li>

        <li style="padding-bottom:15px;">Motiwala Jewels shall not be responsible for any online payment failure and
money being debited from the customer's account. Customers are requested to
check with their banks or other service providers for such payment failures.
</li>

        <li style="padding-bottom:15px;">Motiwala will not be responsible or liable to send reminders for payments.</li>

        <li style="padding-bottom:15px;">In case of any change in contact or address details or any other details that the
customer may have furnished, the customer shall immediately contact us on
9920077780 for effecting the changes. Such modifications made shall be subject
to the satisfaction and discretion of Motiwala.</li>

        <li style="padding-bottom:15px;">.In case of any change in existing laws, rules, notifications, etc. by any regulatory
authority, Motiwala reserves the right to make such
modifications/changes/suspend/discontinue the Plan suitable to the change in
law and necessary requirements as per the same must be complied with by the
customer. Motiwala also reserves the right to alter, amend, add, or delete part or
whole of the privileges of the Plan without prior notice to the customer.
</li>

        <li style="padding-bottom:15px;">Motiwala reserves the right to suspend this Plan at any time.</li>

        <li style="padding-bottom:15px;">Any conditions which are not explicitly covered above would be at the discretion
of Motiwala at the time of transaction. The decision of Motiwala in this regard
would be deemed as irrevocable and final.
</li>

       </ul>
    </div>


 <div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:10px;">
    <div style="margin-bottom:0px">I have read, understood and agree to all the Terms & Conditions of the Golden Treasure Scheme and I agree  to abide by the same.</div>
</div>


</body>
</html>
