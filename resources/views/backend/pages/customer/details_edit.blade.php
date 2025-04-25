<section>

    <div class="row">

        <div class="col-md-12">

            <div class="card col-12 rounded-4">
                <h4 class="card-header">
                    <b>Customer Details</b>
                </h4>
                <hr>
                <div class="card-body pt-2 pt-1">

                    <form id="edit_details_form" action="{{url(route('Customer.edit.details.admin'))}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="user_id">
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="fullname" class="form-label">Name</label>
                                <input type="text" id="fullname" name="fullname" class="form-control" value="{{ $user->fullname ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email_input" name="email" class="form-control" value="{{ $user->email ?? '' }}" readonly disabled>

                                {{-- <div class="form-check">
                                    <input class="form-check-input toggle-edit" type="checkbox" data-target="#email_input" id="edit_email">
                                    <label class="form-check-label" for="edit_email">Edit</label>
                                </div> --}}
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Mobile</label>
                                <input type="text" id="phone_input" name="phone" class="form-control" value="{{ $user->phone ?? '' }}" readonly disabled>

                                {{-- <div class="form-check">
                                    <input class="form-check-input toggle-edit" type="checkbox" data-target="#phone_input" id="edit_phone">
                                    <label class="form-check-label" for="edit_phone">Edit</label>
                                </div> --}}
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="aadhar_number" class="form-label">Aadhar No</label>
                                <input type="text" id="aadhar_number" name="aadhar_number" class="form-control" value="{{ $user_detail->aadhar_number ?? '' }}" readonly disabled>

                                {{-- <div class="form-check">
                                    <input class="form-check-input toggle-edit" type="checkbox" data-target="#aadhar_number" id="edit_aadhar">
                                    <label class="form-check-label" for="edit_aadhar">Edit</label>
                                </div> --}}
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ulp_id" class="form-label">ULP ID (UID)</label>
                                <input type="text" id="ulp_id" name="ulp_id" class="form-control" value="{{ ulp_id($user->id) ?? '' }}" readonly disabled>
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="dob" class="form-label">Birthday</label>
                                <input type="date" id="dob" name="dob" class="form-control" value="{{ $user_detail->dob ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="pan_number" class="form-label">Pancard No</label>
                                <input type="text" id="pan_number" name="pan_number" class="form-control" value="{{ $user_detail->pan_number ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="nominee_name" class="form-label">Nominee Name</label>
                                <input type="text" id="nominee_name" name="nominee_name" class="form-control" value="{{ $user_detail->nominee_name ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="nominee_phone" class="form-label">Nominee Phone No</label>
                                <input type="text" id="nominee_phone" name="nominee_phone" class="form-control" value="{{ $user_detail->nominee_phone ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="nominee_dob" class="form-label">Nominee DOB</label>
                                <input type="date" id="nominee_dob" name="nominee_dob" class="form-control" value="{{ $user_detail->nominee_dob ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="nominee_relation" class="form-label">Nominee Relation</label>
                                <input type="text" id="nominee_relation" name="nominee_relation" class="form-control" value="{{ $user_detail->nominee_relation ?? '' }}">
                            </div>
                    
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" name="address" class="form-control" rows="3">{{ $user_detail->address ?? '' }}</textarea>
                            </div>
                    
                            <div class="col-12 mb-3">
                                <label for="nominee_address" class="form-label">Nominee Address</label>
                                <textarea id="nominee_address" name="nominee_address" class="form-control" rows="3">{{ $user_detail->nominee_address ?? '' }}</textarea>
                            </div>



                            <!------- marital status ---------------------->
                            <div class="col-md-8 col-12 row ms-3 pt-4">

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marital_status" id="single" value="0" @if($user_detail->marital_status == 0) checked @endif>
                                        <label class="form-check-label" for="single">
                                            Single
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marital_status" value="1" id="married" @if($user_detail->marital_status == 1) checked @endif>
                                        <label class="form-check-label" for="married">
                                        Married
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div id="marital_info" class="col-12">
                                <div class="row">
                                    
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mt-4 adhar_field">
                                            <label class="pb-3">Spouse Name </label>
                                            <input type="text" class="form-control" name="spouse_name" pattern="[A-Za-z]+" minlength="3" placeholder="Please Enter Your Spouse Name"
                                            value="{{ $user_detail->spouse_name }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group mt-4 adhar_field">
                                            <label class="pb-3">Spouse Date Of Birth</label>
                                            <input type="date" class="form-control" name="spouse_dob" value="{{ $user_detail->spouse_dob }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group mt-4 adhar_field">
                                            <label class="pb-3">Marriage Date</label>
                                            <input type="date" class="form-control" name="marriage_date" value="{{ $user_detail->marriage_date }}" />
                                        </div>
                                    </div>


                                </div>  
                            </div>

                            <!------ marital status ------------------------>





                            <div class="col-md-10"></div> 
                                <div class="col-md-2 form-group">

                                    <div class="row mt-2 mx-0">

                                        @php
                                            $previousPopupLink = urldecode(request()->input('previous_popup_link'));
                                            $previousPopupName = request()->input('previous_popup_name');
                                        @endphp
                                        <div class="col-md-6">
                                            @if(!empty($previousPopupLink))

                                                    <a href="javascript:void(0);" class="btn btn-secondary rounded-3" onclick="largeModal('{{ $previousPopupLink }}', '{{ $previousPopupName }}');">

                                                            Back

                                                    </a>

                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success rounded-3">Submit </button>
                                        </div>

                                    </div>



                                </div>

                        </div>

                    </form>    
                </div>
            </div>


        </div>

    </div>

</section>


<script>
    document.querySelectorAll('.toggle-edit').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const inputSelector = this.dataset.target;
            const input = document.querySelector(inputSelector);

            if (this.checked) {
                input.removeAttribute('readonly');
                input.removeAttribute('disabled');
                input.setAttribute('required', true);
            } else {
                input.setAttribute('readonly', true);
                input.setAttribute('disabled', true);
                input.removeAttribute('required');
            }
        });
    });

    $(document).ready(function() {
        initValidate('#edit_details_form');
    });

    $("#edit_details_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });

    var responseHandler = function(response) {
        //window.location.href = "{{ $previousPopupLink }}";
        location.reload();
    }


    /*--------------------- Married  ------------------*/ 

    // Get references to the radio buttons and the marital information container
    const singleRadioButton = document.getElementById('single');
    const marriedRadioButton = document.getElementById('married');
    const maritalInfo = document.getElementById('marital_info');

    // Initially hide the marital information since "Single" is checked by default
    maritalInfo.style.display = 'none';

    // Function to add or remove the required attribute from input fields inside the marital information
    function toggleRequired(isMarried) {
        const inputs = maritalInfo.querySelectorAll('input');
        inputs.forEach(input => {
            if (isMarried) {
                input.setAttribute('required', '');
            } else {
                input.removeAttribute('required');
            }
        });
    }

    // Add event listener to the radio buttons
    singleRadioButton.addEventListener('change', function() {
        if (singleRadioButton.checked) {
            maritalInfo.style.display = 'none'; // Hide marital information
            toggleRequired(false); // Remove required attribute from inputs
        }
    });

    marriedRadioButton.addEventListener('change', function() {
        if (marriedRadioButton.checked) {
            maritalInfo.style.display = 'block'; // Show marital information
            toggleRequired(true); // Add required attribute to inputs
        }
    });

    function check_marital_status(){
        if (singleRadioButton.checked) {
            maritalInfo.style.display = 'none'; // Hide marital information
            toggleRequired(false); // Remove required attribute from inputs
        }

        if (marriedRadioButton.checked) {
            maritalInfo.style.display = 'block'; // Show marital information
            toggleRequired(true); // Add required attribute to inputs
        }
    }

    check_marital_status();
</script>
