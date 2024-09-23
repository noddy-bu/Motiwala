@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')



    <!-- -------------------- career banner start ---------------- -->

    <section class="inner_page_banner">
        <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
    </section>


    <main class="main" >
        <section class="openaccount pt-md-5 pt-3 pb-md-5 pb-5">
            <div class="container">
                <div class="row">



                <div class="col-md-12">

                </div>
                    <div class="col-md-12">
                        @include('frontend.pages.admin.new_plan_purchase.reg_form')
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('component.scripts')
    <script>

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
