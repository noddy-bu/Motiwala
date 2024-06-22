<section>
    {{-- @php
        echo"<pre>";
        var_dump($user);
        var_dump($user_detail);
        var_dump($plan_name);
        echo"</pre>";
    @endphp --}}

    <div class="row">

        <div class="col-md-12">

            <div class="card col-md-12 mt-4">
                <h4 class="card-header">
                    <b>Customer Details</b>
                </h4>
                <hr>
                <div class="card-body">


                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <p class="card-text"><strong>Name : </strong>{{ $user->first_name ?? '-' }} {{ $user->last_name ?? '-' }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <p class="card-text"><strong>Email : </strong>{{ $user->email ?? '-' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="card-text">
                                <strong>Birthday : </strong>{{ isset($user_detail->dob) && $user_detail->dob != '' ? date('d/m/Y', strtotime($user_detail->dob)) : '-' }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="card-text"><strong>Mobile : </strong>{{ $user->phone ?? '-'  }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="card-text"><strong>ULP ID (UID) : </strong>{{ $user->ulp_id  ?? '-' }}</p>
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
                            <p class="card-text"><strong>Nominee DOB :
                                </strong>{{ !empty($user_detail->nominee_dob) ? date('d/m/Y', strtotime($user_detail->nominee_dob)) : 'NA' }}
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


        <div class="col-md-6">

            <div class="card col-md-12 mt-3">
                <h4 class="card-header">
                    <b>Plan Details</b>
                </h4>
                <hr>
                <div class="card-body">
                    <p class="card-text"><strong>Plan Type : </strong>{{ $plan_name }}</p>
                    <p class="card-text"><strong>Installment Amount (in Rs) :
                        </strong>{{ $user->installment_amount }}</p>
                </div>
            </div>

        </div>


        <div class="col-md-6">

            <div class="card col-md-12">
                <h4 class="card-header">
                    <b>Verification Details</b>
                </h4>
                <hr>
                <div class="card-body">
                    <div class="row">
                        <p class="col-md-6 card-text"><strong>eKYC Status : </strong>@if(!empty($user_detail->ekyc)) Completed @else Not Completed @endif</p>
                        <p class="col-md-6 card-text"><strong>eSign Status : </strong>@if(!empty($user_detail->esign)) Completed
                        @else Not Completed @endif</p>
                        <p class="col-md-6 card-text"><strong>Payment Status : </strong>@if($user->status == 1) Completed @else Not Completed @endif</p>
                    </div>

                </div>
            </div>

        </div>


        {{-- <div class="col-md-4">
            <div class="card col-md-12 mt-3">
                <div class="card-header">
                    Login Details
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>User ID : </strong>{{ $user->phone }}</p>
                    <p class="card-text"><strong>Password : </strong>{{ $user->phone }}</p>
                    <input type="hidden" name="phone" id="phone" value="{{ $user->phone }}">
                </div>
            </div>

        </div> --}}



    </div>


</section>


<script></script>
