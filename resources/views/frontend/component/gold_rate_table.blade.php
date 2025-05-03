@php
    $plan_minimum_installment = DB::table('plans')->where('id', 2)->value('minimum_installment_amount'); // e.g., 10000

    $gold_rate_per_gm = DB::table('business_settings')->where('type', 'gold_rate_in_1gram_per_day')->value('value'); // e.g., 8800

    $results = [];

    for ($i = 0; $i <= 4; $i++) {
        $increased_rate_per_gm = $gold_rate_per_gm * pow(1.05, $i); // Apply 5% increase i times
        $increased_rate_10_gm = $increased_rate_per_gm * 10;

        $grams = $plan_minimum_installment / $increased_rate_per_gm; // how many grams for 10000
        $month = $i + 1;
        $results[] = [
            'month' => $month,
            'rate_per_gm' => round($increased_rate_per_gm, 2),
            'rate_10_gm' => round($increased_rate_10_gm, 2),
            'grams_you_get' => round($grams, 4),
        ];
    }
@endphp


<div class="table-responsive">


    <table class="table table-bordered">
        <tbody>
            <tr class="table-light">
                <th class="col-md-2">Gold Rate</th>
                <th class="col-md-2">Month</th>
                <th class="col-md-2">Monthly Payment (in INR)</th>
                <th class="col-md-2">Equivalent gold in grams accumulated</th>

            </tr>
            @foreach ($results as $item)
                <tr class="table-light">
                    <td>₹{{ number_format($item['rate_per_gm'], 2) }}</td>
                    <td>{{ $item['month'] }}</td>
                    <td>₹{{ number_format($plan_minimum_installment, 2) }}</td>
                    <td>{{ number_format($item['grams_you_get'], 2) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>


</div>
