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
        <section class="pt-5 inner_sectionpadd">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-center black_color pb-0 heading_font">My Account</h4>
                    </div>

                    {{-- @php
                        var_dump($info);
                    @endphp --}}

                    @php
                        $next_payment_date = $redemption_items
                            ->where('status', 'pending')
                            ->first();

                        $last_payment_date = $redemption_items
                            ->where('status', 'paid')
                            ->sortByDesc('id')
                            ->first();

                        $Maturity_date = $redemption_items
                            ->where('installment_no', (int) $info->installment_period)
                            ->where('status', 'unpaid')
                            ->first();

                        $Installments_paid = $redemption_items
                            ->where('status', 'paid');


                    @endphp
                    <div class="col-md-12 mt-md-4 mt-3">                        
                        <div class="">
                            <div class="col-md-12">
                                <h4>
                                    {{ ucfirst($info->name) }} - {{ account_no($info->id) }}
                                </h4>
                            </div>
                        </div>


                        <div class="col-md-12 mt-md-4 mt-3">
                            <div class="row ">
                                <div class="col-md-6 information_tb">
                                    <div class="card">
                                        <h5 class="card-header">Payment Details</h5>
                                        <div class="card-body">
                                            <p class="card-text">Total Amount Received : {{ $info->total_receivable_amount }}</p>
                                            <p class="card-text">Next Payment Due :
                                                {{ date('d-m-Y', strtotime($next_payment_date->due_date_start)) }}</p>
                                            <p class="card-text">Last Payment Due :
                                                {{ date('d-m-Y', strtotime($last_payment_date->due_date_start)) }}</p>
                                            <p class="card-text">No of Installments Paid : {{ count($Installments_paid) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 information_tb">
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
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-12 information_tb">

                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Transaction ID</th>
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
                                        @if ($row->due_date_start <= date('Y-m-d') && in_array($row->status, ['paid', 'pending']))
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
                                                    @else
                                                        <div class="buttonclass1 mt10">
                                                            <button>Pay</button>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
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
