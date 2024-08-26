 
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
        }

    </style>
</head>
<body>

    <h1> Plan 2 pdf </h1>

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

 <div style="width:100%; clear:both; margin-bottom:0px;padding-top:40px;">
    <div style="margin-bottom:0px">I have read, understood and agree to all the Terms & Conditions of the Golden Treasure Scheme and I agree  to abide by the same.</div>
</div>


</body>
</html>
