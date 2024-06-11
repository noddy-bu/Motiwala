{{---- @php
    $data = [
        'user' => [
            'name' => 'abcd',
            'email' => 'emai@test.com',
            'phone' => '12345678',
            'plan_name' => 'Sample Plan',
        ],
        'user_detail' => [
            'pan_number' => '1234567890',
            'address' => 'gfhgfhgfhf jhgjhgjhgk jkgkjgkjhg kugkugkjhgkj lhkljh kjkhkjhkh',
        ],
    ];
@endphp ----}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details PDF</title>
    <style>

        @font-face {
            font-family: 'Quicksand';
            src: url('https://fonts.gstatic.com/s/quicksand/v31/6xKtdSZaM9iE8KbpRA_hJFQNcOM.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

         body {
            font-family: 'Quicksand', sans-serif;
        }

    </style>
</head>
<body>

    <h1 style="text-align:center; font-size:26px; padding-bottom:20px;">Golden Treasure Plan Customer Application Copy</h1>
    <p><b>Application Number: $data['user']->id</b></p>


    <div style="width:100%;">
    <div style="width:25%; float:left;"><b>Account Holder Name:</b></div>
    <div style="width:75%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user']->name</div>
</div>
<br>

    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:25%; float:left;"><b>Enricle No:</b></div>
    <div style="width:75%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user']->ulp_id</div>
</div>
 <div style="width:50%; ">
    <div style="width:20%; float:left;"><b>Email ID:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user']->email</div>
</div>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:20%; float:left;"><b>Contact Number:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user']->phone</div>
</div>
<br>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:22%; float:left;"><b>Customer Address:</b></div>
    <div style="width:78%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">
        $data['user_detail']['flat_no'] $data['user_detail']['street']
        $data['user_detail']['locality'] $data['user_detail']['city']
        $data['user_detail']['state'] $data['user_detail']['pincode']
    </div>
</div>

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px"><b>Account Information:</b></div>
</div>


    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:57%; float:left;"><b>Installment Amount (Rs.):</b></div>
    <div style="width:43%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user']->installment_amount</div>
</div>
 <div style="width:50%; ">
    <div style="width:40%; float:left;"><b>Scheme Duration:</b></div>
    <div style="width:60%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['plan']->installment_period</div>
</div>

 <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:25%; float:left;"><b>Adhaar No:</b></div>
    <div style="width:75%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user_detail']->aadhar_number</div>
</div>
 <div style="width:50%; ">
    <div style="width:18%; float:left;"><b>Pan No:</b></div>
    <div style="width:82%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user_detail']->pan_number</div>
</div>


 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px;"><b>Nominee Details:</b></div>
</div>


 <div style="width:100%; padding-top:15px;">
    <div style="width:18%; float:left;"><b>Nominee Name:</b></div>
    <div style="width:82%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user_detail']->nominee_name</div>
</div>
<br>

    <div style="width:55%; clear:both; padding-top:15px;">
    <div style="width:70%; float:left;"><b>Relationship with account holder:</b></div>
    <div style="width:30%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user_detail']->nominee_relation</div>
</div>
 <div style="width:45%; ">
    <div style="width:42%; float:left;"><b> Contact Number:</b></div>
    <div style="width:58%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user_detail']->nominee_phone</div>
</div>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:23%; float:left;"><b>Customer Address:</b></div>
    <div style="width:77%; float:left; border-bottom:1px solid #ccc; padding-top:18px;">$data['user_detail']->nominee_address</div>
</div>

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:40px;">
    <div style="margin-bottom:0px">I have read, understood and agree to all the Terms & Conditions of the Golden Harvest Scheme and I agree  to abide by the same.</div>
</div>

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:20px;">
    <div style="margin-bottom:0px">I hereby declare that above bank details are completely correct and I will not raise any claim on TITAN in  case there is discrepancy in the bank details. I also agree with TITAN refunding my principal amount in the  above bank account as per the terms and conditions.</div>
</div>

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px;float:right;"><b>Account Holder Signature</b></div>
</div>


</body>
</html>
