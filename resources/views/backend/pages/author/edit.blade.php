<form id="edit_author_form" action="{{url(route('author.update'))}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
    <div class="col-sm-12">
        <input type="hidden" name="id" value="{{ $author->id }}">
            <div class="form-group mb-3">
                <label>Name <span class="red">*</span></label>
                <input type="text" class="form-control" name="fullname" value="{{ $author->fullname }}" required>
            </div>
        </div>        
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>Email <span class="red">*</span></label>
                <input type="email" class="form-control" name="email" value="{{ $author->email }}" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>Phone <span class="red">*</span></label>
                <input type="text" class="form-control" name="phone" value="{{ $author->phone }}" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>Password <span class="red">*</span></label>
                <input type="password" class="form-control" name="password" value="">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>Designation <span class="red">*</span></label>
                <select class="form-select" name="role_id" required>
                    <option value="">---Select---</option>
                    <option value="2" @if($author->role_id == 2) selected @endif>Admin</option>
                    <option value="3" @if($author->role_id == 3) selected @endif>Staff</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3 text-end">
                <button type="submit" class="btn btn-block btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    initValidate('#edit_author_form');
});

$("#edit_author_form").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, responseHandler);
});

var responseHandler = function(response) {
    location.reload();
}
</script>