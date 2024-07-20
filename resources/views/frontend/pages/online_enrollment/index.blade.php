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
        <section class="openaccount pt-md-5 pt-3 pb-md-5 pb-5">
            <div class="container">
                <div class="row">



                <div class="col-md-12">


            {{-- @php
                
                if (Session::has('step') && Session::get('step') == 1) {
                    $value = 0;
                } elseif (Session::has('step') && Session::get('step') == 3) {
                    $value = 20;
                } elseif (Session::has('step') && Session::get('step') == 4) {
                    $value = 20;
                } elseif (Session::has('step') && Session::get('step') == 6) {
                    $value = 35;
                } elseif (Session::has('step') && Session::get('step') == 7) {
                    $value = 55;
                } elseif (Session::has('step') && Session::get('step') == 8) {
                    $value = 70;
                } elseif (Session::has('step') && Session::get('step') == 12) {
                    $value = 85;
                } elseif (Session::has('payment') && Session::get('payment') == 1) {
                    $value = 100;
                } else {
                    $value = 0;
                }

            @endphp --}}

            {{-- <div class="accordion" id="accordionExample">
                <div class="steps">
                    <progress id="progress" value={{ $value }} max=100 ></progress>
                    <div class="step-item">
                        <button class="step-button text-center" type="button" data-toggle="collapse"
                            data-target="#collapseOne" @if(Session::get('step') >= 1) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapseOne">
                            1
                        </button>
                    </div>
                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" @if(Session::get('step') > 2) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseTwo">
                            2
                        </button>
                    </div>
                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 5) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            3
                        </button>
                    </div>

                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 6) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            4
                        </button>
                    </div>

                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 7) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            5
                        </button>
                    </div>

                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 8) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            6
                        </button>
                    </div>

                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 12) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            7
                        </button>
                    </div>

                    {{-- <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 9) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            8
                        </button>
                    </div>

                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 11) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            9
                        </button>
                    </div>

                    <div class="step-item">
                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" @if(Session::get('step') > 13) aria-expanded="true" @else faria-expanded="alse "@endif aria-controls="collapseThree">
                            10
                        </button>
                    </div>


                </div>

            </div> --}}

                </div>
                    <!-- <div class="col-md-12" id="page-heading">
                        <h4 class="title_heading text-center black_color pb-3 heading_font">Open New Account</h4>
                    </div> -->
                    <div class="col-md-12">

                        @include('frontend.pages.online_enrollment.reg_form')


                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('component.scripts')
    <script>
        /*
        window.addEventListener('beforeunload', function() {

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Specify the URL to hit using the route name
            var url = '{{ route("clear-data") }}';

            // Send a GET request to the URL asynchronously
            xhr.open('GET', url, true);
            xhr.send();

        });
        */

        function back_to_privious(){
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Specify the URL to hit using the route name
            var url = '{{ route("get-privious-page") }}';

            // Send a GET request to the URL asynchronously
            xhr.open('GET', url, true);
            xhr.send();

            setTimeout(function () {
                location.reload();
            }, 1000);

        }

        /*------------------- form submit ajax --------------------*/

        function ajax_form_submit(event, form){

            if (form.valid()) {
                event.preventDefault();

                var button = $(form).find('button[type="submit"]').html();
                $(form).find('button[type="submit"]').html('please wait... <i class="las la-spinner la-spin"></i>');
                $(form).find('button[type="submit"]').css('pointer-events', 'none');
                
                $.ajax({
                    url: $(form).attr('action'),
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (response) {
                        if(response.response_message.response == 'success') {
                            
                            toastr.success(response.response_message.message, response.response_message.response);

                            setTimeout(function() {
                                location.reload();
                            }, 1500);

                        }else{
                            $(form).find('button[type="submit"]').html(button);
                            $(form).find('button[type="submit"]').css('pointer-events', 'inherit');

                            toastr.error(response.response_message.message, response.response_message.response);


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
                toastr.error('Please fill the Mandatory fields ' + errorMessage, 'Error');
                form.find('button[type="submit"]').html(button);
                form.find('button[type="submit"]').css('pointer-events', 'inherit');
            }

        }


    /*------------------- form submit ajax --------------------*/


    
    /*--------------------- add Phone ------------------*/

        initValidate('#phone-verification');

        $('#add-phone form').on('submit', function(event){

            var form = $(this);
            ajax_form_submit(event, form);
        
        });

    /*--------------------- add Phone ------------------*/ 
    
    /*--------------------- verify-otp------------------*/ 

        initValidate('#verify-otp');

        $('#otp form').on('submit', function(event){

            var form = $(this);
            ajax_form_submit(event, form);

        });
    /*--------------------- verify-otp------------------*/    

    /*--------------------- Resend-otp------------------*/    

        $(document).ready(function(){
            $('#resendOTPButton').click(function(e){
                e.preventDefault();

                var csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    url: "{{ route('account.create', ['param' =>'resend-otp']) }}",
                    type: "Post",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        toastr.success(response.response_message.message, response.response_message.response);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(response.response_message.message, response.response_message.response);
                    }
                });
            });
        });

    /*--------------------- Resend-otp------------------*/  
    
    /*--------------------- customer info ------------------*/ 

    initValidate('#customer-info');

    $('#customer-detail form').on('submit', function(event){

        var form = $(this);
        ajax_form_submit(event, form);

    });

    /*--------------------- customer info ------------------*/ 

    /*--------------------- plan info ------------------*/ 

    initValidate('#plan-info');

    $('#plan-detail form').on('submit', function(event){

        var form = $(this);
        ajax_form_submit(event, form);

    });

    /*--------------------- Plan info ------------------*/ 

    /*--------------------- minimum amount ---------------*/

    document.addEventListener('DOMContentLoaded', function() {
        function toggleInstallmentAmount() {
            var selectedOption = document.getElementById('plan_id').querySelector('option:checked');
            var minimumInstallmentAmount = selectedOption.getAttribute('data-minium');
            var installmentAmountElement = document.getElementById('installmentAmount');

            if (selectedOption.value === '') {
                installmentAmountElement.style.display = 'none';
            } else {
                installmentAmountElement.innerHTML = 'Minimum Installment Amount: ' + minimumInstallmentAmount;
                installmentAmountElement.style.display = 'block';
            }
        }

        // Call the function when the select element changes
        document.getElementById('plan_id').addEventListener('change', toggleInstallmentAmount);

        // Call the function on page load
        toggleInstallmentAmount();
    });

    /*--------------------- minimum amount ---------------*/

    /*--------------------- ekyc verify ------------------*/ 

    // initValidate('#ekyc-verify');

    // $('#preview-info form').on('submit', function(event){

    //     var form = $(this);
    //     ajax_form_submit(event, form);

    // });

    /*--------------------- ekyc verify ------------------*/

    /*--------------------- aadhar verify ------------------*/ 

    initValidate('#aadhar-verify-request-otp');

    $('#ekyc form').on('submit', function(event){

        var form = $(this);
        ajax_form_submit(event, form);
        
    });

    /*--------------------- aadhar verify ------------------*/

        /*--------------------- aadhar Resend-otp------------------*/    

        $(document).ready(function(){
            $('#resendAadharOTPButton').click(function(e){
                e.preventDefault();

                var csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    url: "{{ route('account.create', ['param' =>'resend-aadhar-otp']) }}",
                    type: "Post",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        toastr.success(response.response_message.message, response.response_message.response);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(response.response_message.message, response.response_message.response);
                    }
                });
            });
        });

    /*--------------------- aadhar Resend-otp------------------*/  

    /*--------------------- aadhar otp verify ------------------*/ 

    initValidate('#aadhar-otp-verify');

    $('#ekyc-aadhar-otp-verify form').on('submit', function(event){

        var form = $(this);
        ajax_form_submit(event, form);
        
    });

    /*--------------------- aadhar otp verify ------------------*/


    /*--------------------- esign aadhar verify ------------------*/ 

    initValidate('#esign-aadhar-verify-request-otp');

    $('#preview-info form').on('submit', function(event){

        var form = $(this);
        
        if (form.valid()) {
            event.preventDefault();

            var button = $(form).find('button[type="submit"]').html();
            $(form).find('button[type="submit"]').html('please wait... <i class="las la-spinner la-spin"></i>');
            $(form).find('button[type="submit"]').css('pointer-events', 'none');
            
            $.ajax({
                url: $(form).attr('action'),
                type: "POST",
                data: $(form).serialize(),
                success: function (response) {
                    if(response.response_message.response == 'success') {
                        
                        toastr.success(response.response_message.message, response.response_message.response);

                        setTimeout(function() {
                            //location.reload();
                            window.location.href = response.response_message.url;
                        }, 1500);

                    }else{
                        $(form).find('button[type="submit"]').html(button);
                        $(form).find('button[type="submit"]').css('pointer-events', 'inherit');

                        toastr.error(response.response_message.message, response.response_message.response);


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
            toastr.error('Please fill the Mandatory fields' + errorMessage, 'Error');
            form.find('button[type="submit"]').html(button);
            form.find('button[type="submit"]').css('pointer-events', 'inherit');
        }


    });

    /*--------------------- esign aadhar verify ------------------*/








    /*--------------------- Payment Gateway ------------------*/ 

        initValidate('#payment-gateway');

        $('#last-preview-info form').on('submit', function(event){

            var form = $(this);
            if (form.valid()) {
                event.preventDefault();

                var button = $(form).find('button[type="submit"]').html();
                $(form).find('button[type="submit"]').html('please wait... <i class="las la-spinner la-spin"></i>');
                $(form).find('button[type="submit"]').css('pointer-events', 'none');
                
                $.ajax({
                    url: $(form).attr('action'),
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (response) {
                        if(response.response_message.response == 'success') {
                            
                            toastr.success(response.response_message.message, response.response_message.response);

                            var orderId = response.response_message.orderId;
                            var redirectUrl = "{{ url('/create_payumoney') }}/" + orderId;

                            setTimeout(function() {
                                //location.reload();
                                window.location.href = redirectUrl;
                            }, 1500);

                        }else{
                            $(form).find('button[type="submit"]').html(button);
                            $(form).find('button[type="submit"]').css('pointer-events', 'inherit');

                            toastr.error(response.response_message.message, response.response_message.response);


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
                toastr.error('Please fill the Mandatory fields' + errorMessage, 'Error');
                form.find('button[type="submit"]').html(button);
                form.find('button[type="submit"]').css('pointer-events', 'inherit');
            }

        });

    /*--------------------- Payment Gateway ------------------*/ 


    /*--------------------- API forms ------------------*/
     
    $(document).ready(function () {
        var typingTimer;
        var typingDelay = 1000; // 1.2 seconds delay

        $('#pincode').on('keyup', function () {
            clearTimeout(typingTimer);
            var postalCode = $(this).val();

            if (postalCode.length > 0) {
                typingTimer = setTimeout(function () {
                    $.ajax({
                        url: 'https://secure.geonames.org/postalCodeSearchJSON',
                        dataType: 'json',
                        data: {
                            postalcode: postalCode,
                            country: 'IN',
                            username: 'umair.makent'
                        },
                        success: function (data) {
                            if (data.postalCodes.length > 0) {
                                // $('#country_name').val(data.postalCodes[0].countryCode).focus();
                                $('#city').val(data.postalCodes[0].adminName2).focus();
                                $('#state').val(data.postalCodes[0].adminName1).focus();
                                // $('#address').focus();

                                // $('#placeName').val(data.postalCodes[0].placeName);

                                // Display response in a pretty format
                                var responseHtml = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                                $('#response').html(responseHtml);
                            } else {
                                alert('Postal code not found');
                            }
                        },
                        error: function () {
                            alert('Error fetching data');
                        }
                    });
                }, typingDelay);
            }
        });

        // Reset form on click of reset button
        // $('#resetButton').click(function () {
        //     $('#postalCodeForm')[0].reset();
        //     $('#response').empty();
        // });
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
