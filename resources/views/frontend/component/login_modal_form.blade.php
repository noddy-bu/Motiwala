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
              <button class="forget_buttons">Forgot Password</button>
            </div>
            <div class="form-group">
              <div class="buttonclass1 mt60">
                <button type="submit">Sign In <i class="las la-arrow-right"></i>
                </button>
              </div>
            </div>
          </form>

          <p class="pt-5 pb-0 mb-0 fs-14">* If you already have a Golden Harvest A/c, you can sign in here.</p>
          <p class="fs-14"> * User ID is your registered mobile number</p>
        </div>
      </div>
    </div>
  </div>

  @section("login.scripts")
    <script>

        $(document).ready(function(){
            $('#loginForm').submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();
                var csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    url: "{{route('customer.login')}}",
                    type: "Post",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message, response.response);
                        
                        setTimeout(function() {
                            window.location.href = "{{ route('information') }}";
                        }, 1000);
                        

                    },
                    error: function(xhr, status, error) {
                        toastr.error(response.message, response.response);
                    }
                });
            });
        });


    </script>
  @endsection