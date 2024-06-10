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
    <h1>Motiwala & Sons User Details For Esign</h1>
    <p>Name: {{ $data['user']['name'] }}</p>
    <p>Email: {{ $data['user']['email'] }}</p>
    <p>Phone: {{ $data['user']['phone'] }}</p>
    <p>Pan Card No: {{ $data['user_detail']['pan_number'] }}</p>
    <p>Plan Name: {{ $data['user']['plan_name'] }}</p>
</body>
</html>
