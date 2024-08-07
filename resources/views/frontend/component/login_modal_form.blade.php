<div class="modal fade modal_popup_cls" id="loginmodal" aria-hidden="true" aria-labelledby="loginmodal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title title_heading black_color heading_font" id="loginmodal">Sign In</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
 
          <form id="loginForm">
            @csrf
            <div class="form-group mt-4">
              <input type="text" class="form-control" name="phone" placeholder="User ID*" />
            </div>
            <div class="form-group mt-5">
              <input type="password" class="form-control" name="password" placeholder="Password*" />
              <a class="forget_buttons" onclick="open_reset_password_form();">Forgot Password</a>
            </div>
            <div class="form-group">
              <div class="buttonclass1 mt60">
                <button type="submit">Sign In <i class="las la-arrow-right"></i>
                </button>
              </div>
            </div>
          </form>

          <p class="pt-md-5 pt-3 pb-0 mb-0 fs-14">* If you already have a Golden Treasure A/c, you can sign in here.</p>
          <p class="fs-14"> * User ID is your registered mobile number</p>
        </div>
      </div>
    </div>
  </div>

  @section("login.scripts")
  <script>

      function open_reset_password_form(){

        $('#loginmodal').modal('hide');
        $('#forgot_password').modal('show');

      }

      $(document).ready(function(){
          $('#loginForm').submit(function(e){
              e.preventDefault();

              let pay_installments =  "{{ route('pay-installments') }}";
              let information = "{{ route('information') }}";
              let enrollment_page = "{{ route('account.new.enrollment.page') }}";

              var formData = $(this).serialize();
              var csrfToken = '{{ csrf_token() }}';

              $.ajax({
                  url: "{{ route('customer.login') }}",
                  type: "POST",
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  data: formData,
                  dataType: 'json',
                  success: function(response) {
                      if (response.status === 'success') {
                          toastr.success(response.message, 'Success');
                          setTimeout(function() {
                            let fragment = window.location.hash;
                            // Check if the fragment is "#instant-pay"
                            if (fragment === "#instant-pay") {
                              window.location.href = pay_installments;
                            } else {
                              window.location.href = information;
                            }
                              
                          }, 1000);
                      } else if (response.status === 'incomplete') {
                        toastr.success(response.message, 'error');
                          setTimeout(function() {
                              window.location.href = enrollment_page;
                          }, 1000);
                      } else {
                          toastr.error(response.message, 'Error');
                      }
                  },
                  error: function(xhr, status, error) {
                      toastr.error('Something went wrong please try again', 'Error');
                  }
              });
          });

      });
    
    </script>
  @endsection