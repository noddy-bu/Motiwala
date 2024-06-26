<!----============ Form start =================-------------------->
<form id="add_contact_us_form" action="{{url(route('contact.create'))}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row d-flex px-md-0 px-3">

        <div class="col-md-6">
            <div class="form-group mt-4 adhar_field">
                <label class="pb-3">Name *</label>
                <input type="text" class="form-control" name="name" pattern="[A-Za-z]+" minlength="3"
                maxlength="6" placeholder="Please Enter Your Name" value="" required/>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-4 adhar_field">
                <label class="pb-3">Email *</label>
                <input type="eamil" class="form-control" name="email" placeholder="Please Enter Your Email Id" 
                value="" required/>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group mt-4 adhar_field">
                <label class="pb-3">Mobile Number *</label>
                <input type="text" class="form-control" name="phone" pattern="[0-9]+" minlength="10" maxlength="10" placeholder="Please Enter Your Contact Number" value="" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group mt-4 adhar_field">
                <label class="pb-3">Message *</label>
                <textarea class="form-control" row="3" name="description" style="height: 103px;"></textarea>
            </div>
        </div>

        <div class="form-group text-md-center text-center">
            <div class="buttonclass1 mt-5">
                <button type="submit">Submit <i class="las la-arrow-right"></i></button>
            </div>
        </div>


    </div>
</form>

<!----============ Form End =================-------------------->
@section('component.scripts')
<script>
$(document).ready(function() {
    initValidate('#add_contact_us_form');
    $("#add_contact_us_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });

    var responseHandler = function(response) {
        $('input, textarea').val('');
        $("select option:first").prop('selected', true);
        setTimeout(function() {
            location.reload();
            //window.location.href = $('#baseUrl').attr('href') + '/thank-you';
        }, 2000);
    }
});
</script>
@endsection