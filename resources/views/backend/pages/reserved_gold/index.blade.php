@extends('backend.layouts.app')

@section('page.name', 'Set Gold Rate')

@section('page.content')
<div class="card">
   <div class="card-body">
    {{--
      <div class="row mb-2">
         <div class="col-sm-5">
            <h3>Set Reserve gold Rate</h3>
         </div>
      </div> ---}}

      <section>
            <form id="add_setting_form" action="{{url(route('setting.update'))}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- <div class="col-md-12">
                                        <h4 class="header-title"><b>General</b></h4>
                                        <hr>
                                    </div>                          -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>22 karat Gold Price  (Per Gram) *</label>
                                            <input type="text" class="form-control" name="gold_rate_in_1gram_per_day" value="{{ get_settings('gold_rate_in_1gram_per_day') }}">
                                        </div>
                                    </div>
  
                                    
                                <div class="col-md-2">
                                    <div class="form-group d-gridtext-end">
                                        <button type="submit" class="btn btn-block btn-primary">Update</button>
                                    </div>
                                </div>   
                                </div>                                   
                            </div>
                        </div>

                    </div>               
                </div>
            </form>
    </section>
    
   </div>
   <!-- end card-body-->
</div>
@endsection

@section("page.scripts")
<script>
    $(document).ready(function() {
        initValidate('#add_setting_form');
    });
    
    $("#add_setting_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });
    
    var responseHandler = function(response) {
        location.reload();
    }
</script>
@endsection