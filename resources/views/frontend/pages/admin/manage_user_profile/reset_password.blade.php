@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



    <!-- -------------------- career banner start ---------------- -->

    <section class="inner_page_banner">
        <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
    </section>


    <main class="main">
        <section class="openaccount pt-5 pb-5 reset_pass">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="page-heading">
                        <h4 class="title_heading text-center black_color pb-3 heading_font">Reset Password</h4>
                    </div>


                    <div class="col-md-12" id="user_profile_password">

                        <form id="user-panel-password" action="{{ url(route('customer.password.update')) }}" method="post">
                            @csrf

                            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
            
                            <div class="row d-flex">
                                
                                <div class="col-md-12">
                                    <div class="form-group mt-4 adhar_field">
                                        <label class="pb-3">Mobile Number (Username) *</label>
                                        <input type="text" class="form-control"
                                         placeholder="Please Enter Your Mobile Number" value="{{ $user->phone }}" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mt-4 adhar_field">
                                        <label class="pb-3">old Password </label>
                                        <input type="text" class="form-control" name="old_password" minlength="8" maxlength="16" placeholder="Please Enter Your old Password" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-4 adhar_field">
                                        <label class="pb-3">New Password </label>
                                        <input type="text" class="form-control" name="password" minlength="8" maxlength="16" placeholder="Please Enter Your New Password" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-4 adhar_field">
                                        <label class="pb-3">Conform Password </label>
                                        <input type="text" class="form-control" name="password_conform" minlength="8" maxlength="16" placeholder="Please Enter Your Conform Password" required/>
                                    </div>
                                </div>
                    
                                <div class="form-group">
                                    <div class="buttonclass1 mt60">
                                        <button type="submit">Submit <i class="las la-arrow-right"></i></button>
                                    </div>
                                </div>
            
            
                            </div>
            
                        </form>


                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('component.scripts')
    <script>

    /*--------------------- Reset Password ------------------*/ 

        initValidate('#user-panel-password');

        $('#user_profile_password form').on('submit', function(event){

            var form = $(this);
            if (form.valid()) {
                event.preventDefault();

                var button = $(form).find('button[type="submit"]').html();
                $(form).find('button[type="submit"]').html('please wait...');
                $(form).find('button[type="submit"]').css('pointer-events', 'none');
                
                $.ajax({
                    url: $(form).attr('action'),
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (response) {



                        if(response.response == 'success') {

                            
                            toastr.success(response.message, response.response);

                            setTimeout(function() {
                                //location.reload();
                                window.location.href = "{{ url(route('edit-user-profile')) }}";
                            }, 1500);

                        }else{



                            $(form).find('button[type="submit"]').html(button);
                            $(form).find('button[type="submit"]').css('pointer-events', 'inherit');

                            toastr.error(response.message, response.response);


                        }
                        
                    }
                });
            } else {

                // Get all validation errors and display them in Toastr
                var errors = form.validate().errorMap;
                var errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value + '<br>';
                });
                toastr.error(errorMessage, 'Validation Error');
                form.find('button[type="submit"]').html(button);
                form.find('button[type="submit"]').css('pointer-events', 'inherit');
            }

        });

    /*---------------------  Reset Password ------------------*/ 

    

    </script>
@endsection
