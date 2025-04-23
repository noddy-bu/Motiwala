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

                                <div class="form-check">
                                    <input class="form-check-input toggle-edit" type="checkbox" data-target="#email_input" id="edit_email">
                                    <label class="form-check-label" for="edit_email">Edit</label>
                                </div>
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="dob" class="form-label">Birthday</label>
                                <input type="date" id="dob" name="dob" class="form-control" value="{{ $user_detail->dob ?? '' }}">
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Mobile</label>
                                <input type="text" id="phone_input" name="phone" class="form-control" value="{{ $user->phone ?? '' }}" readonly disabled>

                                <div class="form-check">
                                    <input class="form-check-input toggle-edit" type="checkbox" data-target="#phone_input" id="edit_phone">
                                    <label class="form-check-label" for="edit_phone">Edit</label>
                                </div>
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="ulp_id" class="form-label">ULP ID (UID)</label>
                                <input type="text" id="ulp_id" name="ulp_id" class="form-control" value="{{ ulp_id($user->id) ?? '' }}" readonly disabled>
                            </div>
                    
                            <div class="col-md-4 mb-3">
                                <label for="aadhar_number" class="form-label">Aadhar No</label>
                                <input type="text" id="aadhar_number" name="aadhar_number" class="form-control" value="{{ $user_detail->aadhar_number ?? '' }}" readonly disabled>

                                <div class="form-check">
                                    <input class="form-check-input toggle-edit" type="checkbox" data-target="#aadhar_number" id="edit_aadhar">
                                    <label class="form-check-label" for="edit_aadhar">Edit</label>
                                </div>
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
                        </div>
                    </form>    
                </div>
            </div>


        </div>


        {{-- <div class="col-md-6 ">

            <div class="card col-md-12 rounded-4">
                <h4 class="card-header">
                    <b>Plan Details</b>
                </h4>
                <hr>
                <div class="card-body py-2 pt-1">
                    <p class="card-text"><strong>Plan Type : </strong>{{ $plan_name }}</p>
                    <p class="card-text"><strong>Installment Amount (in Rs) :
                        </strong>{{ $installment_amount ??  $user->installment_amount }}</p>
                </div>
            </div>

        </div> --}}

    </div>

    @php
        $previousPopupLink = urldecode(request()->input('previous_popup_link'));
        $previousPopupName = request()->input('previous_popup_name');
    @endphp

    @if(!empty($previousPopupLink))
    <div class="text-end">
        <a href="javascript:void(0);" class="btn btn-sm btn-secondary btn-block pt-1 mt-2" onclick="largeModal('{{ $previousPopupLink }}', '{{ $previousPopupName }}');">
            Back
        </a>
        </div>
    @endif


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
</script>
