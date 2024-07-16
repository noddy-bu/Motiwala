<section class="inner_sectionpadd">
    <div class="container">
        <div class="row">

            @if($info->status == 1)

                <div class="col-md-12" id="closeform">
                    <div class="card">
                        <div class="card-body">
                            <form id="plan_close_form" action="{{url(route('Customer.close.plan'))}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $info->user_id }}" name="user_id">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="card-text">Amount Received at Closing : {{ $total_amount_at_closing }}
                                        </p>
                                        <input type="hidden" value="{{ $total_amount_at_closing }}" name="closing_amount">
                                        <div class="form-group mb-3">
                                            <label>Reason For Closing <span class="red">*</span></label>
                                            <textarea type="text" class="form-control height50" row="2" name="remark" style="height: 103px;" required></textarea>
                                        </div>
                                    </div> 
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3 text-end d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-block btn-primary">Proceed</button>

                                            @php
                                                $previousPopupLink = urldecode(request()->input('previous_popup_link'));
                                                $previousPopupName = request()->input('previous_popup_name');
                                            @endphp
                                            
                                            <a href="javascript:void(0);" class="btn btn-sm btn-secondary btn-block pt-1" onclick="largeModal('{{ $previousPopupLink }}', '{{ $previousPopupName }}');">
                                                 Back
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            @else

                <h3>Plan Has Been Close</h3><br>
                <h5>Amount : {{ $total_amount_at_closing }}</h5>
                <p class="card-text">Reason For Close: {{ $info->closing_remark }}</p>

            @endif


        </div>

    </div>
</section>


<script>
    $(document).ready(function() {
        initValidate('#plan_close_form');
    });

    $("#plan_close_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });

    var responseHandler = function(response) {
        location.reload();
    }
    
</script>
