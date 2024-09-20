

@if (!Session::has('step') || Session::get('step') == 7)

    @php
    session()->forget('step');
    session()->forget('otp_timestamp');
    session()->forget('phone');
    session()->forget('temp_user_id');
    session()->forget('otp');
    Session()->put('step', 7);
    @endphp

    <!--------------------------------------------- plan detail --------------------------------->

    <div id="plan-detail" class="paddingbtm100">

        <div class="p-3 mb-2 text-white" style="background-color:#e1aa7a;">
            <h5 class="mb-0"> Plan Details </h5>
        </div>

        @php
            $user = DB::table('users')
                ->where('id', auth()->user()->id)
                ->get(['plan_id', 'installment_amount'])
                ->first();

            $plan = DB::table('plans')
                ->where('status', 1)
                ->get(['id', 'name', 'minimum_installment_amount']);
        @endphp

        <form id="plan-info" action="{{ url(route('account.create', ['param' => 'plan-info'])) }}" method="post">
            @csrf

            <div class="row d-flex">

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Select Plan *</label>
                        <select class="form-select" aria-label="---Select----" name="plan_id" id="plan_id"
                            required>
                            <option data-minium="3000" value="">---Select---</option>
                            @foreach ($plan as $row)
                                <option data-minium="{{ $row->minimum_installment_amount }}"
                                    value="{{ $row->id }}" @if($row->id == 1) selected @endif>
                                    {{ ucfirst($row->name) }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Installment Amount *</label>

                        <input type="text" class="form-control" name="installment_amount" pattern="[0-9]+"
                            placeholder="Please Enter Your Installment Amount" required />

                        <span id="installmentAmount" style="display: none; color: red;">Minimum Installment Amount :
                            3000.00</span>

                    </div>
                </div>

                <div class="form-group">

                    {{-- <div class="buttonclass me-4">
                        <a class="text-decoration-none text-white" onclick="back_to_privious();"><i class="las la-arrow-left"></i>Back</a>
                    </div> --}}

                    <div class="buttonclass1 mt40">
                        <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                    </div>
                </div>


            </div>

        </form>


    </div>

    <!-------------------------------------------- plan detail --------------------------------->

@endif


@if (Session::has('step') && Session::get('step') == 8)
    <!--------------------------------------------- After aadhar preview info --------------------------------->

    <div id="preview-info">

        @php
            $user = DB::table('users')
                ->where('id', auth()->user()->id)
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','fullname','email', 'phone', 'id'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', auth()->user()->id)
                ->get([
                    'nominee_name',
                    'nominee_phone',
                    'nominee_dob',
                    'nominee_address',
                    'nominee_relation',
                    'aadhar_number',
                    'flat_no',
                    'street',
                    'locality',
                    'state',
                    'city',
                    'pincode',
                    'dob',
                    'address',
                ])
                ->first();

            $plan_name = DB::table('plans')
                ->where('id', $user->plan_id)
                ->value('name');
        @endphp

        <div class="p-3 mb-3 text-white" style="background-color:#e1aa7a;">
            <h5> Preview Info </h5>
        </div>

        <div class="row d-flex">

            <div class="col-md-6 mt-3">

                <div class="card col-md-12">
                    <div class="card-header">
                        Plan Details
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Plan Type : </strong>{{ $plan_name }}</p>
                        <p class="card-text"><strong>Installment Amount (in Rs) :
                            </strong>{{ $user->installment_amount }}</p>
                    </div>
                </div>

            </div>

            <div class="col-md-6 mt-3">


                <div class="card col-md-12">
                    <div class="card-header">
                        Verification Details
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>eKYC Status : </strong>Completed</p>
                        <p class="card-text"><strong>eSign Status : </strong>Not Started</p>
                    </div>
                </div>

            </div>

            <div class="col-md-12 mt-3">

                <div class="card col-md-12">
                    <div class="card-header">
                        Customer Details
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                {{-- <p class="card-text"><strong>Name : </strong>{{ $user->first_name }} {{ $user->last_name }}</p> --}}
                                <p class="card-text"><strong>Name : </strong>{{ $user->fullname }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Email : </strong>{{ $user->email }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Birthday :
                                    </strong>{{ date('d/m/Y', strtotime($user_detail->dob)) }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Mobile : </strong>{{ $user->phone }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>ULP ID (UID) : </strong>{{ ulp_id($user->id) }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Aadhar No :
                                    </strong>{{ !empty($user_detail->aadhar_number) ? $user_detail->aadhar_number : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Name :
                                    </strong>{{ !empty($user_detail->nominee_name) ? $user_detail->nominee_name : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Phone No :
                                    </strong>{{ !empty($user_detail->nominee_phone) ? $user_detail->nominee_phone : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Relation :
                                    </strong>{{ !empty($user_detail->nominee_relation) ? $user_detail->nominee_relation : 'NA' }}
                                </p>
                            </div>


                            <div class="col-md-6 mb-3">
                                <p class="card-text"><strong>Nominee Address :
                                    </strong>{{ !empty($user_detail->nominee_address) ? $user_detail->nominee_address : 'NA' }}
                                </p>
                            </div>
                            
                            <div class="col-md-6">
                                <p class="card-text"><strong>Address : </strong>
                                    @php
                                        echo $user_detail->address;
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

        <div class="p-3 mb-2 text-white mt-3" style="background-color:#e1aa7a;">
            <h5> eSign Process </h5>
        </div>

        <div>
            <div class="steps-title pt-2">
                <p>
                    You are about to be redirected to https://surepass.io, a third party website. The information you provide on
                    the third party website is subject to the terms and conditions, privacy policies and practices of
                    the third party website and we are not responsible for the security and privacy of any information
                    that you may provide on the third party website. </p>
            </div>
        </div>

        <form id="esign-aadhar-verify-request-otp" action="{{ url(route('account.create', ['param' => 'esign-aadhar-verify-request-otp'])) }}"
            method="post">
            @csrf

            <div class="form-group mt-2">
                <input type="checkbox" name="accept_term" id="agree" value="yes" required />
                <label for="agree">I accept <a href="{{ url(route('terms')) }}">“Terms and conditions”</a> </label>
            </div>


            <div class="form-group">
                <div class="buttonclass me-4">
                    <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                </div>
                <div class="buttonclass1 mt40">
                    <button type="submit">Proceed <i class="las la-arrow-right"></i></button>
                </div>
            </div>

        </form>

    </div>

    <!--------------------------------------------- After aadhar preview info --------------------------------->
@endif




@if (Session::has('step') && Session::get('step') == 12)
    <!--------------------------------------------- After esign preview info --------------------------------->

    <div id="last-preview-info">

        @php
            $user = DB::table('users')
                ->where('id', auth()->user()->id)
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','fullname','email', 'phone', 'id'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', auth()->user()->id)
                ->get([
                    'nominee_name',
                    'nominee_phone',
                    'nominee_dob',
                    'nominee_address',
                    'nominee_relation',
                    'aadhar_number',
                    'flat_no',
                    'street',
                    'locality',
                    'state',
                    'city',
                    'pincode',
                    'dob',
                    'address'
                ])
                ->first();

            $plan_name = DB::table('plans')
                ->where('id', $user->plan_id)
                ->value('name');
        @endphp

        <div class="p-3 mb-2 text-white" style="background-color:#e1aa7a;">
            <h5> Preview Info </h5>
        </div>

        <div class="row d-flex">

            <div class="col-md-6">
                <div class="card col-md-12 mt-3">
                    <div class="card-header">
                        Plan Details
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Plan Type : </strong>{{ $plan_name }}</p>
                        <p class="card-text"><strong>Installment Amount (in Rs) :
                            </strong>{{ $user->installment_amount }}</p>
                    </div>
                </div>
            </div>


            <div class="col-md-6">


                <div class="card col-md-12 mt-3">
                    <div class="card-header">
                        Verification Details
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>eKYC Status : </strong>Completed</p>
                        <p class="card-text"><strong>eSign Status : </strong>Completed</p>
                    </div>
                </div>

            </div>

            <div class="col-md-12">

                <div class="card col-md-12 mt-3">
                    <div class="card-header">
                        Customer Details
                    </div>
                    <div class="card-body">


                        <div class="row">


                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Name : </strong>{{ $user->fullname }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Email : </strong>{{ $user->email }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Birthday :
                                    </strong>{{ date('d/m/Y', strtotime($user_detail->dob)) }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Mobile : </strong>{{ $user->phone }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>ULP ID (UID) : </strong>{{ ulp_id($user->id) }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Aadhar No :
                                    </strong>{{ !empty($user_detail->aadhar_number) ? $user_detail->aadhar_number : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Name :
                                    </strong>{{ !empty($user_detail->nominee_name) ? $user_detail->nominee_name : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Phone No :
                                    </strong>{{ !empty($user_detail->nominee_phone) ? $user_detail->nominee_phone : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Address :
                                    </strong>{{ !empty($user_detail->nominee_address) ? $user_detail->nominee_address : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Nominee Relation :
                                    </strong>{{ !empty($user_detail->nominee_relation) ? $user_detail->nominee_relation : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-8 mb-3">
                                <p class="card-text"><strong>Address : </strong>
                                    @php
                                        echo $user_detail->address;
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

        <div>
        </div>

        <form id="payment-gateway" action="{{ url(route('account.create', ['param' => 'payment-gateway'])) }}"
            method="post">
            @csrf

            <div class="form-group">
                <div class="buttonclass me-4">
                    <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                </div>
                <div class="buttonclass1 mt30">
                    <button type="submit">Proceed Payment <i class="las la-arrow-right"></i></button>
                </div>
            </div>

        </form>

    </div>

    <!--------------------------------------------- After esign preview info --------------------------------->
@endif


@if (Session::has('payment') && Session::get('payment') == 1)
    <!--------------------------------------------- After Payment preview info --------------------------------->

    <div id="last-preview-info">

        @php

            $user = DB::table('users')
                ->where('id', auth()->user()->id)
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','fullname','email', 'phone', 'id' , 'created_at'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', auth()->user()->id)
                ->get([
                    'nominee_name',
                    'nominee_phone',
                    'nominee_dob',
                    'nominee_address',
                    'nominee_relation',
                    'aadhar_number',
                    'flat_no',
                    'street',
                    'locality',
                    'state',
                    'city',
                    'pincode',
                    'dob',
                    'address',
                ])
                ->first();

            $plan_name = DB::table('plans')
                ->where('id', $user->plan_id)
                ->value('name');

            $redemptions = DB::table('redemptions')
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->get(['id', 'created_at'])
                ->first();


            if(Session::has('transactions_id')){

                $transactions_details =  DB::table('transactions')
                ->where('id', Session::get('transactions_id'))
                ->get([
                    'payment_id',
                    'payment_amount',
                    'payment_type',
                    'created_at',
                ])
                ->first();

            }

            $account_no = account_no($redemptions->id, date('d-m-Y', strtotime($redemptions->created_at)));

        @endphp

        <div class="row justify-content-center">

            <h2 class="success_heading text-center">you have successfully registered your account</h2>
            <h3 class="login_details text-center">your Transaction details are</h3>

                    <input type="hidden" name="phone" id="phone" value="{{ $user->phone }}">

                    <div class="card col-md-6 row d-flex flex-row text-center mt-3">
                        <h4 class="fw-bold text-center py-3">Transaction ID : {{ $transactions_details->payment_id ?? '-' }}</h4>
                        <p class="col-md-12 text-center">{{ datetimeFormatter($transactions_details->created_at) ?? '-' }}</p>
                        <p class="col-md-12 text-center">Account No : {{ $account_no ?? '-' }}</p>            
                        <p class="col-md-6">Plan Name : {{ $plan_name ?? '-' }}</p>
                        <p class="col-md-6">Installment Amount : {{ $transactions_details->payment_amount ?? '-' }}</p>
                        <p>Your 1st Installment has been Successfully Completed</p>
                    </div>


        </div>

        <div>
        </div>


        <div class="form-group text-center">
            <div class="buttonclass1 mt40">
                <button id="login_page">Proceed to login <i class="las la-arrow-right"></i></button>
            </div>
        </div>



    </div>




    <script>
        var LoginBtn = document.getElementById("login_page");

        // Add event listener to the button
        LoginBtn.addEventListener("click", function() {

            // Get the value of the phone input field
            var phone = document.getElementById("phone").value;

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Specify the URL to hit using the route name
            var url = '{{ route('redirect-login') }}?phone=' + encodeURIComponent(phone);

            // Send a GET request to the URL asynchronously
            xhr.open('GET', url, true);

            // Event listener for when the response is received
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Success: handle auto-login success
                    var response = xhr.responseText.trim();
                    if (response === 'true') {
                        // Redirect to success page or perform other actions
                        window.location.href = "{{ route('pay-installments') }}";
                    } else {
                        window.location.href = "{{ route('pay-installments') }}";
                    }
                } else {
                    window.location.href = "{{ route('pay-installments') }}";
                }
            };


            xhr.send();

            //window.location.href = "{{ url(route('index')) }}/#sign";

        });
    </script>

    <!--------------------------------------------- After Payment preview info --------------------------------->
@endif
