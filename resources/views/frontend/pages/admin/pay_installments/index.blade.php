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
                        $next_payment_date = $transactions
                            ->where('installment', $info->installment_count + 1)
                            ->where('payment_status', 'unpaid')
                            ->first();

                        $last_payment_date = $transactions
                            ->where('installment', $info->installment_count)
                            ->where('payment_status', 'paid')
                            ->first();

                        $Maturity_date = $transactions
                            ->where('installment', (int) $info->installment_period)
                            ->where('payment_status', 'unpaid')
                            ->first();
                    @endphp

                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h4>
                                    {{ ucfirst($info->name) }} - {{ $info->account_number }}
                                </h4>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Payment Details</h4>

                                    <p>Toatal Amount Received : {{ $info->total_paid_amount }}</p><br>
                                    <p>Next Payment Due :
                                        {{ date('d-m-Y', strtotime($next_payment_date->date_of_installment)) }}</p></br>
                                    <p>Last Payment Due :
                                        {{ date('d-m-Y', strtotime($last_payment_date->date_of_installment)) }}</p></br>
                                    <p>No of Installments Paid : {{ $info->installment_count }}</p></br>
                                </div>
                                <div class="col-md-6">
                                    <h4>Maturity Details</h4>

                                    <p>Enrollment Date : {{ date('d-m-Y', strtotime($info->created_at)) }}</p><br>
                                    <p>Maturity Date : {{ date('d-m-Y', strtotime($Maturity_date->date_of_installment)) }}
                                    </p></br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Due Date</th>
                                        <th>Installment No</th>
                                        <th>Installment Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($transactions as $row)
                                        @if( $row->date_of_installment <= date('Y-m-d'))
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    @if ($row->payment_status == 'paid')
                                                        {{ datetimeFormatter($row->created_at) }}
                                                    @else
                                                        {{ date('d-m-Y', strtotime($row->date_of_installment)) }}
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    {{ $row->installment }}
                                                </td>
                                                <td>
                                                    {{ $row->payment_amount }}
                                                </td>
                                                <td>
                                                    @if ($row->payment_status == 'paid')
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
