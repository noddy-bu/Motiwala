<section class="inner_sectionpadd">
    <div class="container">
        <div class="row">

            <div class="col-md-12" id="closeform">
                <div class="card">
                    <div class="card-body">
                        <form id="manual_pay_form" action="{{url(route('Customer.manual.payment'))}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $redemption_items->id }}" name="redemption_items_id">

                            <input type="hidden" value="{{ $user_id }}" name="user_id">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>Amount <b class="text-danger">*</b></label>
                                        <input name="amount" type="text" class="form-control" minlength="3"
                                            maxlength="50" value="{{ $redemption_items->installment_amount }}" required readonly>
                                    </div>
                                </div>
    
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label>Due Date : </label>
                                        {{ $pay_date }}
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>Payment method <b class="text-danger">*</b></label>
                                        <select name="payment_method" class="form-control select2" id="paymentMethod" required>
                                            <option value="">--select--</option>
                                            <option value="cashpay">Cash pay</option>
                                            <option value="checkpay">Check Pay</option>
                                            <option value="upipay">UPI Pay</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="transactionFields1">
                                    <div class="form-group mb-3">
                                        <label>Transaction ID / Check No :</label>
                                        <input name="transaction_id" type="text" class="form-control"   minlength="3"
                                            maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-4" id="transactionFields2">
                                    <div class="form-group mb-3">
                                        <label>Transaction Slip / Check Slip <span class="small">(upload max. 2MB image)</span></label>
                                        <input name="transaction_slip" type="file" class="form-control" 
                                            accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-3 text-end d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-block btn-primary">Proceed</button>

                                        @php
                                            $previousPopupLink = urldecode(request()->input('previous_popup_link'));
                                            $previousPopupName = request()->input('previous_popup_name');
                                        @endphp
                                        <div class="text-end">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-secondary btn-block pt-1" onclick="largeModal('{{ $previousPopupLink }}', '{{ $previousPopupName }}');">
                                                Back
                                        </a>
</div>
                                    </div> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</section>


<script>


    var paymentMethod = document.querySelector('select[name="payment_method"]');
    var transactionFields1 = document.getElementById('transactionFields1');
    var transactionFields2 = document.getElementById('transactionFields2');
    var transactionSlip = document.querySelector('input[name="transaction_slip"]');
    var transactionId = document.querySelector('input[name="transaction_id"]');

    function toggleTransactionFields() {
        if (paymentMethod.value !== 'cashpay') {
            transactionFields1.style.display = 'block';
            transactionFields2.style.display = 'block';
            transactionSlip.setAttribute('required', 'required');
            transactionId.setAttribute('required', 'required');
        } else {
            transactionFields1.style.display = 'none';
            transactionFields2.style.display = 'none';
            transactionSlip.removeAttribute('required');
            transactionId.removeAttribute('required');
        }
    }

    paymentMethod.addEventListener('change', toggleTransactionFields);

    // Trigger change event on page load to handle default selection
    paymentMethod.dispatchEvent(new Event('change'));
    

    $(document).ready(function() {
        initValidate('#manual_pay_form');
    });

    $("#manual_pay_form").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, responseHandler);
    });

    var responseHandler = function(response) {
        //window.location.href = "{{ $previousPopupLink }}";
        location.reload();
    }
</script>
