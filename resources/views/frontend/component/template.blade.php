@php
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
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details PDF</title>
</head>
<body>
    <h1 style="text-align:center;">Golden Treasure Plan Customer Application Copy</h1>
    <p><b>Application Number: 23247646</b></p>

    <p>Pan Card No: {{ $data['user_detail']['pan_number'] }}</p>
    <p>Plan Name: {{ $data['user']['plan_name'] }}</p>

        <div style="width:100%;">
    <div style="width:24%; float:left;"><b>Account Holder Name:</b></div>
    <div style="width:76%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['name'] }}</div>
</div>
<br>

    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:24%; float:left;"><b>Enricle No:</b></div>
    <div style="width:76%; float:left; border-bottom:1px solid #ccc;">1212121</div>
</div>
 <div style="width:50%; ">
    <div style="width:24%; float:left;"><b>Email ID:</b></div>
    <div style="width:76%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['email'] }}</div>
</div>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:20%; float:left;"><b>Contact Number:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['phone'] }}</div>
</div>
<br>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:20%; float:left;"><b>Customer Address:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #000000;">{{ $data['user_detail']['address'] }}</div>
</div>

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px"><b>Account Information:</b></div>
</div>


    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:55%; float:left;"><b>Installment Amount (Rs.):</b></div>
    <div style="width:45%; float:left; border-bottom:1px solid #ccc;">1212121</div>
</div>
 <div style="width:50%; ">
    <div style="width:40%; float:left;"><b>Scheme Duration:</b></div>
    <div style="width:60%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['email'] }}</div>
</div>

 <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:24%; float:left;"><b>Adhaar No:</b></div>
    <div style="width:76%; float:left; border-bottom:1px solid #ccc;">1212121</div>
</div>
 <div style="width:50%; ">
    <div style="width:18%; float:left;"><b>Pan No:</b></div>
    <div style="width:82%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['email'] }}</div>
</div>


 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:50px;">
    <div style="margin-bottom:0px"><b>Nominee Details:</b></div>
</div>


 <div style="width:100%; padding-top:15px;">
    <div style="width:17%; float:left;"><b>Nominee Name:</b></div>
    <div style="width:83%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['name'] }}</div>
</div>
<br>

    <div style="width:50%; clear:both; padding-top:15px;">
    <div style="width:70%; float:left;"><b>Relationship with account holder:</b></div>
    <div style="width:30%; float:left; border-bottom:1px solid #ccc;">1212121</div>
</div>
 <div style="width:50%; ">
    <div style="width:37%; float:left;"><b> Contact Number:</b></div>
    <div style="width:63%; float:left; border-bottom:1px solid #ccc;">{{ $data['user']['email'] }}</div>
</div>
 <div style="width:100%; clear:both; padding-top:15px;">
    <div style="width:20%; float:left;"><b>Customer Address:</b></div>
    <div style="width:80%; float:left; border-bottom:1px solid #000000;">{{ $data['user_detail']['address'] }}</div>
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
