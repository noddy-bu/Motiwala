@php
    $this_pop_link = urlencode(full_url());
    $this_pop_name = 'Customer Installment';
@endphp

<section class="pt-5 inner_sectionpadd">
    <div class="container">
        <div class="row">
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


            @endphp
            <div class="col-md-12 md-4">                        
                <div class="">
                    <div class="col-md-12">
                        <h4>
                            {{ ucfirst($info->name) }} - {{ account_no($info->id) }}
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

                                    @if($next_payment_date != null)
                                        <p class="card-text">Next Payment Due :
                                            {{ date('d-m-Y', strtotime($next_payment_date->due_date_start)) }}</p>
                                    @else
                                        <p class="card-text">Installment Payment :
                                            Completed</p>
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
                                    <p class="card-text">Enrollment Date : {{ date('d-m-Y', strtotime($info->created_at)) }}</p>
                                    <p class="card-text">Maturity Date : {{ date('d-m-Y', strtotime($Maturity_date->due_date_start)) }}
                                    </p>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 information_tb mb-3">
                            <div class="card">
                                <h5 class="card-header">Plan Details</h5>
                                <div class="card-body">
                                    <p class="card-text">
                                        Plan Status : @if($info->status == 1) Active
                                        @else Close @endif
                                    </p>
                                    
                                    @if($info->status == 1)
                                        <div style="float: right;">
                                            <a href="javascript:void(0);" 
                                            class="btn btn-sm btn-secondary" 
                                            onclick="largeModal('{{ url(route('Customer.close.form', ['id' => $info->user_id])) }}?previous_popup_link={{ $this_pop_link }}&previous_popup_name={{ $this_pop_name }}', 'Closeing Plan');">
                                                Close Plan
                                            </a>
                                        </div>
                                    @else
                                        <hr>
                                        <h3 class="text-center">Plan Has Been Closed</h3>
                                        <p class="card-text">Close Date: {{ $info->closing_date }}</p>
                                        <p class="card-text">Close at Amount: {{ $total_amount_at_closing }}</p>
                                        <p class="card-text">Reason For Close: {{ $info->closing_remark }}</p>
                                    @endif


                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            {{-- @if($info->status == 1)

                <div class="col-md-12 d-none" id="closeform">
                    <hr>
                    <div class="card">
                        <h5 class="card-header">Closing Plan</h5>
                        <div class="card-body">
                            <form id="plan_close_form" action="{{url(route('Customer.close.plan'))}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $info->user_id }}" name="user_id">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="card-text">Amount Received at Closing : {{ $total_amount_at_closing }}
                                        </p>
                                        <div class="form-group mb-3">
                                            <label>Reason For Closing <span class="red">*</span></label>
                                            <textarea type="text" class="form-control height50" row="2" name="remark" style="height: 103px;" required></textarea>
                                        </div>
                                    </div> 
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3 text-end">
                                            <button type="submit" class="btn btn-block btn-primary">Proceed</button>
                                            <a class="btn btn-block btn-danger" id="closeformbtn">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endif --}}


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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($redemption_items as $row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if ($row->status == 'paid')
                                                @php
                                                    $transaction_id = DB::table('transactions')->where('id', $row->transaction_id)->value('payment_id');
                                                @endphp
                                                {{ $transaction_id }}
                                            @else
                                                NA
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->status == 'paid')
                                                {{ datetimeFormatter($row->receipt_date) }}
                                            @else
                                                NA
                                            @endif
                                            
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($row->due_date_start)) }}</td>
                                        <td>
                                            {{ $row->installment_no }}
                                        </td>
                                        <td>
                                            {{ $row->installment_amount }}
                                        </td>
                                        <td>
                                            @if ($row->status == 'paid')
                                                Paid
                                            @elseif ($row->status == 'pending')
                                                pending
                                            @else
                                                unpaid
                                            @endif
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>


<script>

    // document.getElementById('closebtn').addEventListener('click', function() {
    //     if (confirm('Are you sure to close?')) {
    //         document.getElementById('closebtn').classList.toggle('d-none');
    //         document.getElementById('closeform').classList.toggle('d-none');
    //     }
    // });

    // document.getElementById('closeformbtn').addEventListener('click', function() {
    //     document.getElementById('closebtn').classList.toggle('d-none');
    //     document.getElementById('closeform').classList.toggle('d-none');
    // });


    $(document).ready(function() {
        initValidate('#plan_close_form');
    });

    $("#plan_close_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });

    var responseHandler = function(response) {
        location.reload();
    }
</script>


