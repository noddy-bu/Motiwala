@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')

    <!-- -------------------- Terms  start ---------------- -->

    <section class="inner_page_banner">
        <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
    </section>


    <!-- -------------------- privacy content  start ---------------- -->

    <main class="main">
        <section class="pt-5 inner_sectionpadd pay_installments">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-center black_color pb-0 heading_font">My Account</h4>
                    </div>

                    {{-- @php
                        var_dump($info);
                    @endphp --}}

                    @php
                        $total_receivable_amount = $redemption_items
                            ->where('status', 'paid')
                            ->sum('installment_amount');

                        $next_payment_date = $redemption_items
                            ->where('status', 'pending')
                            ->first();

                        $last_payment_date = $redemption_items
                            ->where('status', 'paid')
                            ->sortByDesc('id')
                            ->first();

                        $Maturity_date = $redemption_items
                            ->where('installment_no', (int) $info->installment_period)
                            ->first();

                        $Installments_paid = $redemption_items
                            ->where('status', 'paid');

                        if($info->status != 1){
                            $close_plan_name = DB::table('plans')->where('id', $info->close_planid)->value('name');
                        }

                    @endphp
                    <div class="col-md-12 mt-md-4 mt-3">                        
                        <div class="">

                            <div class="col-md-12 text-center">
                                <h4 class="account_number">
                                    @if($info->status == 1) {{ ucfirst($info->name) }} @else {{ ucfirst($close_plan_name) }} @endif - {{ account_no($info->redemptions_id, date('d-m-Y', strtotime($info->redemptions_created_at))) }}
                                </h4>
                            </div>
                        </div>


                        <div class="col-md-12 mt-md-4 mt-3">
                            <div class="row ">
                                <div class="col-md-4 information_tb">
                                    <div class="card">
                                        <h5 class="card-header">Payment Details</h5>
                                        <div class="card-body">
                                            <p class="card-text">Total Amount Received : {{ $total_receivable_amount }}</p>
                                            @if($info->status != 1)
                                                @if($next_payment_date != null)
                                                <p class="card-text">Next Payment Due :
                                                    {{ date('d-m-Y', strtotime($next_payment_date->due_date_start)) }}</p>
                                                @else
                                                <p class="card-text">Installment Payment :
                                                    Completed</p>
                                                @endif
                                            @endif
                                            <p class="card-text">Last Payment Due :
                                                {{ date('d-m-Y', strtotime($last_payment_date->due_date_start)) }}</p>
                                            <p class="card-text">No of Installments Paid : {{ count($Installments_paid) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 information_tb mb-3">
                                    <div class="card">
                                        <h5 class="card-header">Maturity Details</h5>
                                        <div class="card-body">
                                            <p class="card-text">Enrollment Date : {{ date('d-m-Y', strtotime($info->redemptions_created_at)) }}</p>
                                            {{-- <p class="card-text">Maturity Date : {{ date('d-m-Y', strtotime($Maturity_date->due_date_start)) }}
                                            </p> --}}
                                            
                                            <p class="card-text">Maturity Date : {{ date('d-m-Y', strtotime($info->maturity_date_start)) }}
                                            </p>
                                            <br>
                                            @if($info->status == 0)
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 information_tb mb-3">
                                    <div class="card">
                                        <h5 class="card-header">Plan Details</h5>
                                        <div class="card-body">
                                            <p class="card-text">
                                                Plan Name : @if($info->status == 1) {{ ucfirst($info->name) }} @else {{ ucfirst($close_plan_name) }} @endif
                                            </p>
                                            <p class="card-text">
                                                Installment Amount : {{ $info->installment_amount }}
                                            </p>
                                            <p class="card-text">
                                                Plan Status : @if($info->status == 1) Active
                                                @else Close @endif
                                            </p>
                                            @if($info->status != 1)
                                                <hr>
                                                <p class="card-text">Close Date: {{ $info->closing_date }}</p>
                                                <p class="card-text">Remark: {{ $info->closing_remark }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-12 information_tb">

                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Receipt ID</th>
                                        <th>Receipt Date</th>
                                        <th>Due Date</th>
                                        <th>Installment No</th>
                                        <th>Installment Amount</th>
                                        @if($info->close_planid == 2)
                                            <th>Reserved Gold</th>
                                        @endif
                                        <th>Payment Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($redemption_items as $row)
                                        {{-- @if ($row->due_date_start <= date('Y-m-d') && in_array($row->status, ['paid', 'pending'])) --}}
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    @if ($row->status == 'paid')
                                                        {{-- @php
                                                            $transaction_id = DB::table('transactions')->where('id', $row->transaction_id)->value('payment_id');
                                                        @endphp --}}
                                                        {{ $row->id }}
                                                    @else
                                                        NA
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (in_array($row->status, ['paid','request_approval']))
                                                        {{ custom_date_change($row->receipt_date) }}
                                                    @else
                                                        NA
                                                    @endif
                                                    
                                                </td>
                                                {{-- <td>{{ date('d-m-Y', strtotime($row->due_date_start)) }}</td> --}}
                                                <td>
                                                    @if ($row->installment_no == 1)
                                                        -
                                                    @else
                                                        {{ custom_date_change($row->due_date_start) }}
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    {{ $row->installment_no }}
                                                </td>
                                                <td>
                                                    {{ $row->installment_amount }}
                                                </td>
                                                @if($info->close_planid == 2)
                                                    <td>
                                                        {{ gold_prifix($row->receivable_gold) ?? "-" }}
                                                    </td>
                                                @endif
                                                <td>
                                                    @if (in_array($row->status, ['paid','request_approval']))
                                                        @php
                                                            $transaction_payment_type = DB::table('transactions')->where('id', $row->transaction_id)->value('payment_type');
                                                        @endphp
                                                        @if($transaction_payment_type == "payu")
                                                            PayU
                                                        @elseif ($transaction_payment_type == "cashpay")
                                                            Cash Pay
                                                        @elseif ($transaction_payment_type == "upipay")
                                                            UPI
                                                        @elseif ($transaction_payment_type == "checkpay")
                                                            Check Pay
                                                        @else
                                                            NA
                                                        @endif
                                                    @else
                                                        NA
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (in_array($row->status, ['paid','request_approval']))
                                                        Paid
                                                    @else
                                                        {{-- @if ($row->due_date_start <= date('Y-m-d') && in_array($row->status, ['paid', 'pending'])) --}}
                                                        @if (in_array($row->status, ['paid', 'pending']))

                                                            @if($info->status == 1)
                                                                <div class="buttonclass mt10">
                                                                    <a href="{{ url(route('installments.payment')) }}" id="pay-link" data-id="{{ $row->id }}">
                                                                        Pay
                                                                    </a>
                                                                </div>
                                                            @else
                                                                Unpaid
                                                            @endif
                                                        @else 

                                                            @if($info->status == 1)
                                                                <div class="buttonclass greybg mt10">
                                                                    <a style="opacity: 0.5;pointer-events: none;">
                                                                        Pay
                                                                    </a>
                                                                </div>
                                                            @else
                                                                Unpaid
                                                            @endif

                                                        @endif

                                                    @endif
                                                </td>
                                            </tr>
                                        {{-- @endif --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- -------------------- privacy content  end   ---------------- -->

@endsection

@section("page.scripts")
<script>
    $(document).ready(function() {
        $('#pay-link').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            var rowId = $(this).data('id'); // Get the row ID from the data attribute

            var btn = $(this);
            var btn_text = $(btn).html();
            $(btn).html('<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>');
            $(btn).css('opacity', '0.7');
            $(btn).css('pointer-events', 'none');

            var action = $(this).attr('href');
            $.ajax({
                type: "POST",
                url: action,
                dataType: 'json',
                data: {
                    id: rowId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    $(btn).html(btn_text);
                    $(btn).css('opacity', '1');
                    $(btn).css('pointer-events', 'inherit');
                    console.log(response.status);
                    if (response.response == 'success') {
                        toastr.success(response.message, "Success");

                        var orderId = response.orderId;
                        var redirectUrl = "{{ url('/create_payumoney_installment') }}/" + orderId;

                        setTimeout(function() {
                            //location.reload();
                            window.location.href = redirectUrl;
                        }, 1000);

                    } else {

                        toastr.error(response.notification, "Alert");
                        
                    }
                },
                error: function(xhr, status, error) {
                    $(btn).html(btn_text);
                    $(btn).css('opacity', '1');
                    $(btn).css('pointer-events', 'inherit');
                    toastr.error("An error occurred while processing the payment", "Error");
                }
            });
        });
    });
</script>

@if (session('toastr'))
<script>
    $(document).ready(function() {
        var type = "{{ session('toastr.type') }}";
        var message = "{{ session('toastr.message') }}";
        var title = "{{ session('toastr.title') }}";

        toastr[type](message, title);
    });
</script>
@endif

@endsection

