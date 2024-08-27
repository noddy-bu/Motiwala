 
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
    <title>E-sign Golden Harvest Plan Customer Application</title>
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
    <div style="margin-bottom:0px"><b>Agreement for Sale of Jewellery</b></div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px">WHEREAS, the proposed purchaser desires to avail of the scheme and to purchase gold and
diamond jewellery on monthly installment basis from the jeweler</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px">WHEREAS, It is agreed that the selection of diamond jewellery by the proposed purchaser will
be at the time when the payment of the eleven installments is complete.</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:15px;">
    <div style="margin-bottom:0px">WHEREAS, it is clarified at the outset that gold chains, gold bars and silver bars are not offered
by the jeweler in this scheme and only gold and Diamond Jewelry can be taken under this
scheme.
</div>
</div>

<div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:30px;">
    <div style="margin-bottom:0px"><b>Now it is hereby agreed by and between the parties hereto as follows:-</b></div>
</div>

<div style="width:100%; clear:both; margin-bottom:0px;padding-top:0px;">
    <div class="text_fonts" style="margin-bottom:0px">

    <ul style="list-style: decimal;">
        <li style="padding-bottom:15px;">It is agreed between the parties hereto that the recitals contained hereinabove shall form
an integral part of this Agreement as if the same is reproduced verbatim herein.</li>
        <li style="padding-bottom:15px;">The jeweller hereby declares, represents and warrants that he will sell gold and diamond
jewellery to the proposed purchaser of which he is the absolute owner and over which
he has or will have good right, full power and absolute authority in all respects.</li>
        <li style="padding-bottom:15px;">The applicable market rate of the gold and diamond jewellery will be as prevailing at the
time when the proposed purchaser completes the payment of the 11" installment. Such
date will be the deedias date of placing the order.
</li>
        <li style="padding-bottom:15px;">The proposed purchaser agrees to pay 10 installments of Rs. _ _ _ _ _each to the j_ _ _
calendar month on or before the 3 days of the starting date e.i. first installment. The s _ _
installment shall be paid by the proposed purchaser at the time of executing this
agreement</li>
        <li style="padding-bottom:15px;">As soon as the proposed purchaser tenders the 10" installment, the jeweler shall _ _ _ _
purchaser to select the gold and diamond jewellery (the market cost of which shall not be
less than twelve times the monthly installment). The jeweler shall handover the selected
gold and diamond jewellery to the proposed purchaser who will then become the
absolute owner. The 11 month installment is agreed to be waived off by the jeweler.
However if the value of the selected jewellery is more than 11 times the monthly
installment, the excess amount can be paid in cash/ cheque.</li>
        <li style="padding-bottom:15px;">The jeweler shall tender a proper receipt to the proposed purchaser for each installment.</li>
        <li style="padding-bottom:15px;">The jeweler shall give a proper tax invoice to the proposed purchaser at the time of
handing over the diamond jewellery.
</li>
        <li style="padding-bottom:15px;">It shall be the duty of the proposed purchaser to tender the installments on a timely basis
to the jeweler</li>
        <li style="padding-bottom:15px;" >The jeweler will have a right to cancel the agreement if the installment is not paid by the
proposed purchaser on time and shall also have the right to forfeit the installments. The
proposed purchaser is aware that the installments paid by him/her are non-refundable
partly and fully.
</li>
        <li style="padding-bottom:15px;" >This agreement supersedes all the catalogues, brochures, pamphlets and/or
advertisement (printed or displayed) and/or promotion made hitherto by the jeweler. That
the terms, conditions and assurances made in this agreement by the parties shall be
final.
</li>
        <li style="padding-bottom:15px;">This agreement has been entered into with the free consent of both parties as
specifically defined under Section 14 of the Indian Contract Act, 1872.
</li>
        <li style="padding-bottom:15px;">The rights and liabilities of the parties under this agreement shall be governed by the
Sales of Goods Act, 1930 and any other applicable law.
</li>
        <li style="padding-bottom:15px;">In case of any dispute between the parties, the dispute shall be referred to the
JEWELLERY trade association who shall appoint a sole arbitrator to adjudicate the
dispute. The decision of the arbitrator shall be final and the proceedings shall be
governed by the provisions of the Arbitration and Conciliation Act, 1996.</li>
        <li style="padding-bottom:15px;"> The details for communication between the parties will be as under:</li>
    </ul>
    </div>

     <div class="text_fonts" style="width:100%; clear:both; margin-bottom:0px;padding-top:10px;">
    <div style="margin-bottom:0px">I have read, understood and agree to all the Terms & Conditions of the Golden Treasure Scheme and I agree  to abide by the same.</div>
</div>


</div>


</body>
</html>
