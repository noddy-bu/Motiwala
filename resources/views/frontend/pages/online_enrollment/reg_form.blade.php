@if (!Session::has('step') || Session::get('step') == 1)
    <!--------------------------------------------------------- add phone ----------------------------------->

    <div id="add-phone">

     <div>
                        <p>Hello,
                        
                        <p>   
                           We sincerely appreciate your interest in opening a new account with our Motiwala Jewels Golden Treasure Purchase Plan.
                        </p>
                        <p>To help us expedite your request, please proceed with the following steps.</p>
                    </div>



        @php
            session()->forget('step');
            session()->forget('otp_timestamp');
            session()->forget('phone');
            session()->forget('temp_user_id');
            session()->forget('otp');
            Session()->put('step', 1);
        @endphp

        <form id="phone-verification" action="{{ url(route('account.create', ['param' => 'phone-verification'])) }}"
            method="post">
            @csrf

            <div class="form-group mt-2">
                <input class="me-2" type="checkbox" name="accept_term" id="agree" value="yes" required />
                <label for="agree">I accept <a href="{{ url(route('terms')) }}">“Terms & conditions”</a></label>
            </div>


            <div class="d-flex flex-md-row flex-column">
                <div class="form-group mt-3 adhar_field">
                    <label class="pb-2">Mobile Number* </label>
                    <input type="text" class="form-control" name="phone" placeholder="Please Enter Mobile Number"
                        pattern="[0-9]+" minlength="10" maxlength="10" placeholder="Please Enter Mobile Number"
                        required />
                </div>

                <div class="form-group">
                    <div class="buttonclass1 mt40 ms-md-4 ms-0">
                        <button type="submit">Proceed <i class="las la-arrow-right"></i></button>
                    </div>
                </div>
            </div>

        </form>

    </div>

    <!--------------------------------------------- add phone --------------------------------->
@endif






@if (Session::has('step') && Session::get('step') == 2)
    <!--------------------------------------------- verify otp --------------------------------->

    <div id="otp">

        <div class="row">
            <form class="col-md-9" id="verify-otp" action="{{ url(route('account.create', ['param' => 'verify-otp'])) }}"
                method="post">
                @csrf

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group mt-4 adhar_field">
                            <label class="pb-2">Mobile Number</label>
                            <input type="text" class="form-control" value="{{ Session::get('phone') }}" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mt-4 adhar_field">
                            <label class="pb-2">Verify OTP *</label>
                            <input type="text" class="form-control" name="otp" pattern="[0-9]+" minlength="6"
                                maxlength="6" placeholder="Please Enter OTP" required />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group text-end">

                            <div class="buttonclass me-4 mb-3">
                                <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                            </div>

                            <div class="buttonclass1 mt40">
                                <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                            </div>
                            <a class="ms-4 d-sm-inline d-block" id="resendOTPButton">Resend OTP</a>


                        </div>
                    </div>


                </div>



            </form>


        </div>

    </div>

    <!--------------------------------------------- verify otp --------------------------------->
@endif



@if (Session::has('step') && Session::get('step') == 3)
    <!--------------------------------------------- ekyc Aadhar verify --------------------------------->

    <div id="ekyc">

        <div class="row">
            <form class="col-md-12" id="aadhar-verify-request-otp"
                action="{{ url(route('account.create', ['param' => 'aadhar-verify-request-otp'])) }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mt-4 adhar_field">
                            <label class="pb-3">Aadhaar *</label>
                            <input type="text" class="form-control" name="aadhar" pattern="[0-9]+"
                                minlength="12" maxlength="12" placeholder="Please Enter Aadhar No" required />
                        </div>
                    </div>
                    {{-- <div class="col-md-4">

                        <div class="form-group mt-4 adhar_field">
                            <label class="pb-3">Confirm Aadhaar *</label>
                            <input type="text" class="form-control" name="aadhar_conform" pattern="[0-9]+"
                                minlength="12" maxlength="12" placeholder="Please Enter Aadhar No" required />
                        </div>


                    </div> --}}


                </div>

                <div class="form-group col-md-8 text-end">
                    <div class="buttonclass me-4">
                        <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                    </div>
                    <div class="buttonclass1 mt40">
                        <button type="submit">Verify <i class="las la-arrow-right"></i></button>
                    </div>
                </div>

            </form>

        </div>

    </div>

    <!--------------------------------------------- ekyc Aadhar verify --------------------------------->
@endif


@if (Session::has('step') && Session::get('step') == 4)
    <!--------------------------------------------- ekyc Aadhar verify --------------------------------->

    <div id="ekyc-aadhar-otp-verify">

        <div class="row">
            <form class="col-md-7" id="aadhar-otp-verify"
                action="{{ url(route('account.create', ['param' => 'aadhar-otp-verify'])) }}" method="post">
                @csrf

             
                <div class="row">
<div class="col-md-6">
 <div class="form-group mt-4 adhar_field">
                        <label class="pb-2">Verify OTP *</label>
                        <input type="text" class="form-control" name="otp" pattern="[0-9]+" minlength="6"
                            maxlength="6" placeholder="Please Enter OTP" required />
                    </div>
</div>

              <div class="col-md-6"></div> 

                 <div class="d-flex gap-2 mt-2" id="countdown_div">
                    <p>Resend OTP After</p>
                    <div id="countdown"></div>
                 </div>
        

                    <div class="form-group col-md-12 text-end d-flex flex-row mt-4">
                        <div id="ReSubmit" class="buttonclass me-4 d-none">
                            <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                        </div>
                        <div class="buttonclass1">
                            <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                        </div>
                        <div id="ReSubmitAadhar" class="ms-4 mt-2 d-none">
                            <a class="d-sm-inline d-block" id="resendAadharOTPButton">Resend OTP</a>
                        </div>
                    </div>


                </div>

            </form>


        </div>

    </div>



    <script>
        // Reload the page after 5 seconds
        setTimeout(function() {
            var ReSubmitBtn = document.getElementById("ReSubmit");
            var resendAadharotp = document.getElementById("ReSubmitAadhar");

            var countdown_div = document.getElementById("countdown_div");

            countdown_div.classList.add("d-none");

            ReSubmitBtn.classList.remove("d-none"); // Remove the "d-none" class to display the button
            resendAadharotp.classList.remove("d-none"); // Remove the "d-none" class to display the button

            // Add event listener to the button
            ReSubmitBtn.addEventListener("click", function() {
                // Create an XMLHttpRequest object
                var xhr = new XMLHttpRequest();

                // Specify the URL to hit using the route name
                var url = '{{ route('resubmit-aadhar-otp') }}';

                // Send a GET request to the URL asynchronously
                xhr.open('GET', url, true);
                xhr.send();

                // Reload the page after hitting the route
                location.reload();
            });

        }, 60000); // 5000 milliseconds = 5 seconds
    </script>

    <script>
        // Set the time we're counting down to (1 minute from now)
        var countDownDate = new Date().getTime() + 60000; // 60000 milliseconds = 1 minute

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for minutes and seconds
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="countdown"
            document.getElementById("countdown").innerHTML = minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>


    <!--------------------------------------------- ekyc Aadhar verify --------------------------------->
@endif


@if (Session::has('step') && Session::get('step') == 5)
    <!--------------------------------------------- ekyc Aadhar verify --------------------------------->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the elements by their IDs
            var pageHeading = document.getElementById("page-heading");
            var pageContain = document.getElementById("page-contain");

            // Set the display style to 'block' to make them visible
            pageHeading.style.display = "none";
            pageContain.style.display = "none";
        });


        // Reload the page after 3 seconds
        setTimeout(function() {

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Specify the URL to hit using the route name
            var url = '{{ route('update-session') }}';

            // Send a GET request to the URL asynchronously
            xhr.open('GET', url, true);
            xhr.send();


            location.reload();
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>


    <div id="aadhar-preview">

        @php

            $customer_detail = Session::get('customer_detail');

            $profileImage = $customer_detail['profileImage'];
            $fullName = $customer_detail['name'];
            $address = $customer_detail['address'];
            $zip = $customer_detail['zip'];
            $dob = $customer_detail['dob'];
            $care_of = $customer_detail['care_of'];
            $mobile = $customer_detail['mobile'];

            Session()->put('address', $address);
            Session()->put('fullname', $fullName);

        @endphp

        <div class="row d-flex justify-content-center">
            <h3 class="text-center">Please wait for proceeding...</h3>
            <div class="card col-md-12 my-5 mx-2" style="width: 40rem;">
                <div class="card-header">
                    Final KYC Result
                </div>

                <div class="d-flex justify-content-center">
                    <img src="data:image/png;base64,{{ $profileImage }}" class="card-img-top thum"
                        alt="profile-image" style="width: 250px;">
                </div>

                <div class="card-body">
                    <p class="card-text"><strong>Name : </strong>{{ $fullName }}</p>
                    <p class="card-text"><strong>DOB : </strong>{{ $dob }}</p>
                    <p class="card-text"><strong>Mobile : </strong>{{ $mobile }}</p>
                    <p class="card-text"><strong>Address : </strong>
                        {{ $care_of }}
                        @php
                            echo $address->house . ",\n";
                            echo $address->loc . ",\n";
                            echo $address->landmark . ",\n";
                            echo $address->street . ",\n";
                            echo $address->vtc . ",\n";
                            echo $address->subdist . ",\n";
                            echo $address->dist . ",\n";
                            echo $address->state . ",\n";
                            echo $address->country;
                        @endphp
                        {{ $zip }}
                    </p>
                </div>
            </div>

        </div>

        
            {{-- <div class="buttonclass me-4">
                <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
            </div> --}}

    </div>

    <!--------------------------------------------- ekyc Aadhar verify --------------------------------->

@endif



@if (Session::has('step') && Session::get('step') == 6)

    <!--------------------------------------------- customer detail --------------------------------->

    <div id="customer-detail" class="paddingbtm100">


        <div class="p-3 mb-2 text-white" style="background-color:#e1aa7a;">
            <h5 class="mb-0"> Customer Information </h5>
        </div>

        @if (Session::has('temp_user_id') && !empty(Session::get('temp_user_id')))
            @php
                $user = DB::table('users')
                    ->where('id', Session::get('temp_user_id'))
                    ->get(['salutation', 'first_name', 'last_name','fullname','email', 'phone'])
                    ->first();
                $user_detail = DB::table('userdetails')
                    ->where('user_id', Session::get('temp_user_id'))
                    ->get(['flat_no', 'street', 'locality', 'state', 'city', 'pincode', 'dob', 'pan_number','nominee_name', 'nominee_phone', 'nominee_dob', 'nominee_address', 'nominee_relation','address'])
                    ->first();


                if(Session::has('address')){
                    $address = Session::get('address');

                    $customer_address = $address->house . ' ' . $address->loc . ' ' . $address->landmark . ' ' . $address->street . ' ' . $address->vtc . ' ' . $address->subdist . ' ' . $address->dist . ' ' . $address->state . ' ' . $address->country;
                } else {
                    $customer_address = '';
                }
                
                if(Session::has('fullname')){
                    $fullname = Session::get('fullname');
                } else {
                    $fullname = '';
                }



            @endphp
        @endif

        <form id="customer-info" action="{{ url(route('account.create', ['param' => 'customer-info'])) }}"
            method="post">
            @csrf

            <div class="row d-flex">


                {{-- <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Title *</label>
                        <select class="form-select" aria-label="---Select----" name="title" required>
                            <option value="">---Select---</option>
                            <option value="Mr" @if ($user->salutation == 'Mr') selected @endif>Mr</option>
                            <option value="Ms" @if ($user->salutation == 'Ms') selected @endif>Ms</option>
                            <option value="Mrs" @if ($user->salutation == 'Mrs') selected @endif>Mrs</option>
                            <option value="Dr" @if ($user->salutation == 'Dr') selected @endif>Dr</option>
                            <option value="CA" @if ($user->salutation == 'CA') selected @endif>CA</option>
                            <option value="Lawyer" @if ($user->salutation == 'Lawyer') selected @endif>Lawyer</option>
                            <option value="Minor" @if ($user->salutation == 'Minor') selected @endif>Minor</option>
                        </select>
                    </div>
                </div> --}}

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Full Name *</label>
                        <input type="text" class="form-control uppercase" name="fullname" pattern="[A-Za-z]+" minlength="3"
                            maxlength="50" placeholder="Please Enter Your Full Name" value="{{ $user->fullname ?? $fullname}}" required />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Last Name *</label>
                        <input type="text" class="form-control uppercase" name="last_name" pattern="[A-Za-z]+" minlength="1"
                            maxlength="20" placeholder="Please Enter Your Last Name" value="{{ $user->last_name }}" required />
                    </div>
                </div> --}}

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Email *</label>
                        <input type="eamil" class="form-control" name="email"
                            placeholder="Please Enter Your Email Id" value="{{ $user->email }}" required />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Pan Card Number </label>
                        <input type="text" class="form-control text-uppercase" name="pan_number"
                            placeholder="Please Enter Your Pan Card Number" pattern="[0-9A-Za-z]+" value="{{ $user_detail->pan_number }}" minlength="10" maxlength="10" />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Door No / Flat NO *</label>
                        <input type="text" class="form-control" name="flat_no" pattern="[0-9A-Za-z]+"
                            placeholder="Please Enter Your Door No / Flat No" value="{{ $user_detail->flat_no }}"
                            required />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Street / Road / Sector / Building *</label>
                        <input type="text" class="form-control" name="street" pattern="[0-9A-Za-z]+"
                            placeholder="Please Enter Your Street" value="{{ $user_detail->street }}" required />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Area / Locality / LandMark *</label>
                        <input type="text" class="form-control" name="locality" pattern="[0-9A-Za-z]+"
                            placeholder="Please Enter Your Locality" value="{{ $user_detail->locality }}" required />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Pin Code *</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" pattern="[0-9]+" minlength="3"
                            placeholder="Please Enter Your Pin Code" value="{{ $user_detail->pincode }}" required />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">State *</label>
                        <input type="text" class="form-control" id="state" name="state" pattern="[A-Za-z\s]+"
                            minlength="3" placeholder="Please Enter Your State" value="{{ $user_detail->state }}"
                            required />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">City / Town *</label>
                        <input type="text" class="form-control" id="city" name="city" pattern="[A-Za-z]+"
                            minlength="3" placeholder="Please Enter Your City" value="{{ $user_detail->city }}"
                            required />
                    </div>
                </div> --}}



                <div class="col-md-8">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-3">Address *</label>
                        <textarea class="form-control height15" row="2" name="address" id="address" style="height: 103px;">{{ $user_detail->address ?? $customer_address }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-3">DOB * ( As per Aadhar )</label>
                        <input type="date" class="form-control" name="dob" value="{{ $user_detail->dob }}" max="{{ date('Y-m-d', strtotime('-18 years')) }}" required />
                    </div>
                </div>


            {{------------------------------------ Nomine ----------------------------------}}    

            <div class="p-3 ps-4 mb-2 text-white nominee_details mt-5" style="background-color:#e1aa7a;">
                <h5 class="mb-0"> Nominee Details</h5>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-md-5 mt-3 adhar_field">
                    <label class="pb-2">Name </label>
                    <input type="text" class="form-control  uppercase" name="nominee_name" pattern="[A-Za-z]+"
                        minlength="3" placeholder="Please Enter Your Nominee Name"
                        value="{{ $user_detail->nominee_name }}" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-md-5 mt-3 adhar_field">
                    <label class="pb-2">Contact Number </label>
                    <input type="text" class="form-control" name="nominee_phone" pattern="[0-9]+"
                        minlength="10" maxlength="10" placeholder="Please Enter Your Nominee Contact Number"
                        value="{{ $user_detail->nominee_phone }}" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-md-5 mt-3 adhar_field">
                    <label class="pb-2">Date Of Birth</label>
                    <input type="date" class="form-control" name="nominee_dob"
                        value="{{ $user_detail->nominee_dob }}" max="{{ date('Y-m-d') }}" />
                </div>
            </div>

            <div class="col-md-8" id="nomine_address">
                <div class="form-group mt-md-5 mt-3 adhar_field">
                    <label class="pb-3">Address *</label>
                    <textarea class="form-control height15" row="2" name="nominee_address" style="height: 103px;">{{ $user_detail->nominee_address }}</textarea>
                </div>
            </div>

            <div class="col-md-8 d-none" id="residence_address">
                <div class="form-group mt-md-5 mt-3 adhar_field">
                    <label class="pb-3">Address </label>
                    <textarea class="form-control height15" row="3" name="residence_nominee_address" id="residence_nominee_address" style="height: 103px;"></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-md-5 mt-3 adhar_field">
                    <label class="pb-2">Relationship with Account Holder</label>
                    <input type="text" class="form-control" name="nominee_relation" pattern="[A-Za-z]+"
                        minlength="3" placeholder="Please Enter Your Relationship with Account Holder"
                        value="{{ $user_detail->nominee_relation }}" />
                </div>
            </div>

            <div class="form-group mt-2">
                <input class="me-2" type="checkbox" name="residence_address_check" id="residence_address_check" value="1" />
                <label for="residence_address_check">As Per Residence address</label>
            </div>



            {{------------------------------------ Nomine ----------------------------------}}  




                <div class="form-group text-end pe-md-5">
                    <div class="buttonclass me-4">
                        <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                    </div>
                    <div class="buttonclass1 mt40">
                        <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                    </div>
                </div>


            </div>

        </form>


    </div>

    <!--------------------------------------------- customer detail --------------------------------->

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var residenceAddressCheck = document.getElementById('residence_address_check');
            var nomineAddress = document.getElementById('nomine_address');
            var Address = document.getElementById('address');
            var residence_nominee_address = document.getElementById('residence_nominee_address');
            var residenceAddress = document.getElementById('residence_address');

            if (residenceAddressCheck && nomineAddress && Address && residenceAddress) {
                residenceAddressCheck.addEventListener('change', function() {
                    if (this.checked) {
                        nomineAddress.classList.add('d-none');
                        residence_nominee_address.value = Address.value;
                        residenceAddress.classList.remove('d-none');
                    } else {
                        nomineAddress.classList.remove('d-none');
                        residenceAddress.classList.add('d-none');
                    }
                });
            }
        });
    </script>

@endif


@if (Session::has('step') && Session::get('step') == 7)

    <!--------------------------------------------- plan detail --------------------------------->

    <div id="plan-detail" class="paddingbtm100">

        <div class="p-3 mb-2 text-white" style="background-color:#e1aa7a;">
            <h5 class="mb-0"> Plan Details </h5>
        </div>

        @php
            $user = DB::table('users')
                ->where('id', Session::get('temp_user_id'))
                ->get(['plan_id', 'installment_amount'])
                ->first();
            // $user_detail = DB::table('userdetails')
            //     ->where('user_id', Session::get('temp_user_id'))
            //     ->get(['nominee_name', 'nominee_phone', 'nominee_dob', 'nominee_address', 'nominee_relation', 'flat_no', 'street', 'locality', 'state', 'city', 'pincode'])
            //     ->first();
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
                            {{-- @foreach ($plan as $row)
                            <option data-minium="{{ $row->minimum_installment_amount }}" value="{{ $row->id }}" @if ($user->plan_id == $row->id) selected @endif>
                                {{ ucfirst($row->name) }}
                            </option>
                        @endforeach --}}
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
                        {{-- <input type="text" class="form-control" name="installment_amount" pattern="[0-9]+" placeholder="Please Enter Your Installment Amount" value="{{ $user->installment_amount }}" required/> --}}
                        <input type="text" class="form-control" name="installment_amount" pattern="[0-9]+"
                            placeholder="Please Enter Your Installment Amount" required />

                        <span id="installmentAmount" style="display: none; color: red;">Minimum Installment Amount :
                            3000.00</span>

                    </div>
                </div>

                {{-- <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Nominee Name </label>
                        <input type="text" class="form-control  uppercase" name="nominee_name" pattern="[A-Za-z]+"
                            minlength="3" placeholder="Please Enter Your Nominee Name"
                            value="{{ $user_detail->nominee_name }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Nominee Contact Number </label>
                        <input type="text" class="form-control" name="nominee_phone" pattern="[0-9]+"
                            minlength="10" maxlength="10" placeholder="Please Enter Your Nominee Contact Number"
                            value="{{ $user_detail->nominee_phone }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Nominee Date Of Birth</label>
                        <input type="date" class="form-control" name="nominee_dob"
                            value="{{ $user_detail->nominee_dob }}" />
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-2">Relationship with Account Holder</label>
                        <input type="text" class="form-control" name="nominee_relation" pattern="[A-Za-z]+"
                            minlength="3" placeholder="Please Enter Your Relationship with Account Holder"
                            value="{{ $user_detail->nominee_relation }}" />
                    </div>
                </div>
                <div class="col-md-12" id="nomine_address">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-3">Nominee Address *</label>
                        <textarea class="form-control height50" row="2" name="nominee_address" style="height: 103px;">{{ $user_detail->nominee_address }}</textarea>
                    </div>
                </div>

                <div class="col-md-12 d-none" id="residence_address">
                    <div class="form-group mt-md-5 mt-3 adhar_field">
                        <label class="pb-3">Nominee Address *</label>
                        <textarea class="form-control height50" row="3" name="residence_nominee_address" style="height: 103px;">{{ $user_detail->flat_no }} {{ $user_detail->street }} {{ $user_detail->locality }} {{ $user_detail->state }} {{ $user_detail->city }} {{ $user_detail->pincode }}</textarea>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <input class="me-2" type="checkbox" name="residence_address_check" id="residence_address_check" value="1" />
                    <label for="residence_address_check">As Per Residence address</label>
                </div> --}}

                <div class="form-group">

                    <div class="buttonclass me-4">
                        <a class="text-decoration-none text-white" onclick="back_to_privious();"><i class="las la-arrow-left"></i>Back</a>
                    </div>

                    <div class="buttonclass1 mt40">
                        <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                    </div>
                </div>


            </div>

        </form>


    </div>
{{-- 
    <script>
        document.getElementById('residence_address_check').addEventListener('change', function() {
            var nomineAddress = document.getElementById('nomine_address');
            var residenceAddress = document.getElementById('residence_address');

            if (this.checked) {
                nomineAddress.classList.add('d-none');
                residenceAddress.classList.remove('d-none');
            } else {
                nomineAddress.classList.remove('d-none');
                residenceAddress.classList.add('d-none');
            }
        });
    </script> --}}

    <!--------------------------------------------- plan detail --------------------------------->

@endif

{{-- 
@if (Session::has('step') && Session::get('step') == 8)
    <!--------------------------------------------- preview info --------------------------------->

    <div id="preview-info">

        @php
            $user = DB::table('users')
                ->where('id', Session::get('temp_user_id'))
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','email', 'phone'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', Session::get('temp_user_id'))
                ->get([
                    'nominee_name',
                    'nominee_phone',
                    'nominee_dob',
                    'nominee_address',
                    'nominee_relation',
                    'flat_no',
                    'street',
                    'locality',
                    'state',
                    'city',
                    'pincode',
                    'dob',
                ])
                ->first();

            $plan_name = DB::table('plans')
                ->where('id', $user->plan_id)
                ->value('name');
        @endphp

        <div class="p-3 mb-3 text-white" style="background-color:#e1aa7a;">
            <h5 class="mb-0"> Preview Info </h5>
        </div>

        <div class="row d-flex">

            <div class="col-md-6 pt-3">

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

            <div class="col-md-6 pt-3">
                <div class="card col-md-12">
                    <div class="card-header">
                        Verification Details
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>eKYC Status : </strong>Not Started</p>
                        <p class="card-text"><strong>eSign Status : </strong>Not Started</p>
                    </div>
                </div>

            </div>

            <div class="col-md-12 pt-3">

                <div class="card col-md-12">
                    <div class="card-header">
                        Customer Details
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Name : </strong>{{ $user->first_name }} {{ $user->last_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Email : </strong>{{ $user->email }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Birthday :
                                    </strong>{{ date('d/m/Y', strtotime($user_detail->dob)) }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Mobile : </strong>{{ $user->phone }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>ULP ID (UID): </strong>NA</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Nominee Name :
                                    </strong>{{ !empty($user_detail->nominee_name) ? $user_detail->nominee_name : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Nominee Phone No :
                                    </strong>{{ !empty($user_detail->nominee_phone) ? $user_detail->nominee_phone : 'NA' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Nominee DOB :
                                    </strong>{{ !empty($user_detail->nominee_dob) ? date('d/m/Y', strtotime($user_detail->nominee_dob)) : 'NA' }}
                                </p>
                            </div>

                             <div class="col-md-4">
                                <p class="card-text pb-2"><strong>Nominee Relation :
                                    </strong>{{ !empty($user_detail->nominee_relation) ? $user_detail->nominee_relation : 'NA' }}
                                </p>
                            </div>

                            <div class="col-12">
                                <p class="card-text pb-2"><strong>Nominee Address :
                                    </strong>{{ !empty($user_detail->nominee_address) ? $user_detail->nominee_address : 'NA' }}
                                </p>
                            </div>
                           
                            <div class="col-12">
                                <p class="card-text pb-2"><strong>Address : </strong>
                                    @php
                                        echo $user_detail->flat_no . ",\n";
                                        echo $user_detail->street . ",\n";
                                        echo $user_detail->locality . ",\n";
                                        echo $user_detail->city . ",\n";
                                        echo $user_detail->state . ",\n";
                                        echo $user_detail->pincode;
                                    @endphp
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div>

        <div class="p-3 mb-2 text-white mt-4" style="background-color:#e1aa7a;">
            <h5 class="mb-0"> eKYC Process </h5>
        </div>

        <div>
            <div class="steps-title pt-4">

                <p><b>Terms and Conditions</b></p>
                <p>By clicking on proceed button below, you are hereby acknowledging that you are providing your Aadhaar
                    related details voluntarily to Motiwala Jewels Gold and Diamonds Pvt Private Limited to retrieve your Aadhaar
                    Paperless-XML from the UIDAI Portal on your behalf based on the process detailed below. It is not
                    mandatory for you to provide your Aadhaar details. If you do not wish to continue with providing the
                    same, request you to cancel the transactions. I understand that Motiwala Jewels Gold and Diamonds Pvt Private Limited will
                    be able to access my photograph through XML file being parsed from the database of Unique
                    Identification Authority of India, to further share the same with the service provider. If you do
                    not agree for us to access the same, request you to not click on Proceed.
                </p>
                <p>By accepting the Terms & Conditions you are expressly providing your consent to the collection of
                    your information for the purpose of providing access of the same by Motiwala Jewels Gold and Diamonds Pvt to enable
                    (“Client”) to initiate your on boarding to avail the Client’s services. The information you provide
                    may be used to help improve and train our products and assist in the development of any technologies
                    and in addition Motiwala Jewels Gold and Diamonds Pvt may use the above information to fulfil any other lawful purpose.
                    Motiwala Jewels Gold and Diamonds Pvt shall be redacting and collecting your Aadhaar number. The first 8 digits of the
                    Aadhaar number will be blacked out when you insert the same on to the webpage. You shall be prompted
                    to insert the Aadhaar number twice, in order to ensure its correctness and the Aadhaar number will
                    be encrypted and transferred/ accessed.
                </p>

                <p>The following screens will capture your Aadhaar number / VID and other relevant details required to
                    download Paperless-XML from UIDAI Portal <a
                        href="https://myaadhaar.uidai.gov.in/">https://myaadhaar.uidai.gov.in/ </a> instead of
                    forwarding you to UIDAI portal.
                </p>

                <p><strong>We will be doing the ID KYC process including the following steps:</strong></p>

                <ul class="steps_li">
                    <li>Connecting to UIDAI portal and fetching XML.</li>
                    <li>Capturing OTP/TOTP and Validating it using UIDAI portal.</li>
                    <li>Sending request to UIDAI portal and get response HTML.</li>
                    <li>Parsing HTML and populate fields in the UI.</li>
                    <li>Sending request to offline Aadhaar portal to download the ZIP file protected with Share code.
                    </li>
                    <li>Application fetches ZIP XML response from Offline Aadhaar in memory.</li>
                    <li>ZIP XML File and Share code is shared with requesting agency for consuming KYC data.</li>

                </ul>
            </div>
        </div>

        <form id="ekyc-verify" action="{{ url(route('account.create', ['param' => 'ekyc-varification'])) }}"
            method="post">
            @csrf

            <div class="form-group mt-2">
                <input type="checkbox" name="accept_term" id="agree" value="yes" required />
                <label for="agree">I accept <a href="{{ url(route('terms')) }}">“Terms and conditions”</a></label>
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

    <!--------------------------------------------- preview info --------------------------------->
@endif --}}



@if (Session::has('step') && Session::get('step') == 8)
    <!--------------------------------------------- After aadhar preview info --------------------------------->

    <div id="preview-info">

        @php
            $user = DB::table('users')
                ->where('id', Session::get('temp_user_id'))
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','fullname','email', 'phone', 'id'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', Session::get('temp_user_id'))
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
                                        // echo $user_detail->flat_no . ",\n";
                                        // echo $user_detail->street . ",\n";
                                        // echo $user_detail->locality . ",\n";
                                        // echo $user_detail->city . ",\n";
                                        // echo $user_detail->state . ",\n";
                                        // echo $user_detail->pincode;
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




{{-- @if (Session::has('step') && Session::get('step') == 10)
    <!--------------------------------------------- eSign Aadhar verify --------------------------------->

    <div id="esign" class="paddingbtm100">

        @php
            $user = DB::table('users')
                ->where('id', Session::get('temp_user_id'))
                ->get(['first_name','last_name', 'email', 'phone'])
                ->first();
        @endphp

        <div class="row">
            <form class="col-md-12" id="esign-aadhar-verify-request-otp"
                action="{{ url(route('account.create', ['param' => 'esign-aadhar-verify-request-otp'])) }}"
                method="post">
                @csrf


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mt-3 adhar_field">
                            <label class="pb-2">Full Name *</label>
                            <input type="text" class="form-control uppercase" name="name" pattern="[A-Za-z]+"
                                minlength="3" maxlength="20" placeholder="Please Enter Your Name"
                                value="{{ $user->first_name }} {{ $user->last_name }}" readonly required />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mt-3 adhar_field">
                            <label class="pb-2">Email *</label>
                            <input type="eamil" class="form-control" name="email"
                                placeholder="Please Enter Your Email Id" value="{{ $user->email }}" readonly
                                required />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mt-3 adhar_field">
                            <label class="pb-2">Phone No *</label>
                            <input type="text" class="form-control" name="phone" pattern="[0-9]+"
                                minlength="10" maxlength="10" placeholder="Please Enter Phone No"
                                value="{{ $user->phone }}" readonly required />
                        </div>
                    </div>

                    <div class="form-group text-end">

                        <div class="buttonclass me-4">
                            <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                        </div>

                        <div class="buttonclass1 mt40">
                            <button type="submit">Verify <i class="las la-arrow-right"></i></button>
                        </div>
                    </div>
                </div>







            </form>

        </div>

    </div>

    <!--------------------------------------------- eSign Aadhar verify --------------------------------->
@endif --}}


{{-- @if (Session::has('step') && Session::get('step') == 11)
    <!--------------------------------------------- eSign Aadhar otp verify --------------------------------->

    <div id="ekyc-aadhar-otp-verify">

        <div class="row">
            <form class="col-md-5" id="aadhar-otp-verify"
                action="{{ url(route('account.create', ['param' => 'eSign-aadhar-otp-verify'])) }}" method="post">
                @csrf

                <div class="row">

                <div class="col-md-6">
                    <div class="form-group mt-3 adhar_field">
                        <label class="pb-2">Verify OTP *</label>
                        <input type="text" class="form-control" name="otp" pattern="[0-9]+" minlength="6"
                            maxlength="6" placeholder="Please Enter OTP" required />
                    </div>
                </div>

                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <div class="form-group text-end">
                    <div class="buttonclass me-4">
                        <a class="" onclick="back_to_privious();"><i class="las la-arrow-left"></i> Back</a>
                    </div>
                    <div class="buttonclass1 mt40">
                        <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                    </div>
                </div>
                
            </div>
                  
                </div>


                

            </form>

        </div>

    </div>

    <!--------------------------------------------- eSign Aadhar otp verify --------------------------------->
@endif --}}


@if (Session::has('step') && Session::get('step') == 12)
    <!--------------------------------------------- After esign preview info --------------------------------->

    <div id="last-preview-info">

        @php
            $user = DB::table('users')
                ->where('id', Session::get('temp_user_id'))
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','fullname','email', 'phone', 'id'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', Session::get('temp_user_id'))
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
                                        // echo $user_detail->flat_no . ",\n";
                                        // echo $user_detail->street . ",\n";
                                        // echo $user_detail->locality . ",\n";
                                        // echo $user_detail->city . ",\n";
                                        // echo $user_detail->state . ",\n";
                                        // echo $user_detail->pincode;
                                        echo $user_detail->address;
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

        <!-- <div class="p-3 mb-2 text-white mt-4" style="background-color:#e1aa7a;">
            <h5> Payment Details </h5>
        </div> -->

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
                ->where('id', Session::get('temp_user_id'))
                ->get(['plan_id', 'installment_amount', 'first_name','last_name','fullname','email', 'phone', 'id' , 'created_at'])
                ->first();

            $user_detail = DB::table('userdetails')
                ->where('user_id', Session::get('temp_user_id'))
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
                ->orderBy('id', 'desc') // Order by latest id
                ->first(['id', 'created_at']);  // Get only the first record

            $account_count = DB::table('redemptions')->where('user_id', $user->id)->count();

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

{{--
        <!-- <div class="p-3 mb-2 text-white" style="background-color:#e1aa7a;">
            <h5> Preview Info </h5>
        </div> -->
            --}}

        <div class="row justify-content-center">
            {{--
            <!-- <div class="col-md-4">

                <div class="card col-md-12 mt-2">
                    <div class="card-header">
                        Plan Details
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Plan Type : </strong>{{ $plan_name }}</p>
                        <p class="card-text"><strong>Installment Amount (in Rs) :
                            </strong>{{ $user->installment_amount }}</p>
                    </div>
                </div>

            </div> --> 
            --}}


           
            {{-- <!-- <div class="col-md-4">

                <div class="col-md-12 mt-2">


                    <div class="card col-md-12">
                        <div class="card-header">
                            Verification Details
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>eKYC Status : </strong>Completed</p>
                            <p class="card-text"><strong>eSign Status : </strong>Completed</p>

                            <p class="card-text"><strong>Payment Status : </strong>Completed</p>
                        </div>
                    </div>

                </div>

            </div> -->
            --}}


            


            <h2 class="success_heading text-center">you have successfully registered your account</h2>
            <h3 class="login_details text-center">your Transaction details are</h3>

                    {{-- <div class="row col-md-6 p-3 px-2 mb-2 text-dark text-center mt-2 rounded-3" style="background-color:#fff;">
                        <p class="col-md-6 mb-0"><strong>User ID : </strong>{{ $user->phone }}</p>
                        <p class="col-md-6 mb-0"><strong>Password : </strong>{{ $user->phone }}</p>
                        <input type="hidden" name="phone" id="phone" value="{{ $user->phone }}"> 
                    </div>--}}

                    <input type="hidden" name="phone" id="phone" value="{{ $user->phone }}">

                    <div class="card col-md-6 row d-flex flex-row text-center mt-3">
                        <h4 class="fw-bold text-center py-3">Transaction ID : {{ $transactions_details->payment_id ?? '-' }}</h4>
                        <p class="col-md-12 text-center">{{ datetimeFormatter($transactions_details->created_at) ?? '-' }}</p>
                        <p class="col-md-12 text-center">Account No : {{ $account_no ?? '-' }}</p>            
                        <p class="col-md-6">Plan Name : {{ $plan_name ?? '-' }}</p>
                        <p class="col-md-6">Installment Amount : {{ $transactions_details->payment_amount ?? '-' }}</p>
                        <p>Your 1st Installment has been Successfully Completed</p>
                    </div>


            
            {{--
            <!-- <div class="col-md-12">

                <div class="card col-md-12 mt-2">
                    <div class="card-header">
                        Customer Details
                    </div>
                    <div class="card-body">


                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <p class="card-text"><strong>Name : </strong>{{ $user->first_name }} {{ $user->last_name }}</p> 
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
                           
                            <div class="col-md-6 mb-3">
                                <p class="card-text"><strong>Address : </strong>
                                    @php
                                        // echo $user_detail->flat_no . ",\n";
                                        // echo $user_detail->street . ",\n";
                                        // echo $user_detail->locality . ",\n";
                                        // echo $user_detail->city . ",\n";
                                        // echo $user_detail->state . ",\n";
                                        echo $user_detail->address;
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div> -->
            --}}


        </div>

            {{--
        <!-- <div class="p-3 mb-2 text-white mt-2" style="background-color:#e1aa7a;">
            <h5> Login </h5>
        </div> -->
            --}}

        <div>
        </div>

        
        <div class="form-group text-center">
            <div class="buttonclass1 mt40">
                <button id="login_page">{{ $account_count > 1 ? 'Continue' : 'Proceed to login' }} <i class="las la-arrow-right"></i></button>
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
