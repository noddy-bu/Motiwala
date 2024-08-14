@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.content')

    <section class="inner_page_banner">
        <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
    </section>


    <main class="main vh100" id="fail_installment_page">

    <section class="mt-10">
    	<div class="success_page padd70">
    		<div class="container text-center">
                <img class="fail_image pb-md-4" src="/assets/frontend/images/cancel.png" alt="fail-image">
    			<div class="success_box">
                    <h3>Transaction failed due to : {{ $errorMessage }}</h3>
    				<h5>Your order status is <b>{{ $data['status'] }}</b>
    				</h5>
    				<h5>Your transaction id for this transaction is <b>{{ $data['txnid'] }}</b>
    				</h5>
                    <div class="buttonclass py-2 pb-3 mt-4">
    				    <a class="" href="{{ url(route('pay-installments')) }}">Back</a>
                    </div>
                   </div>
    		</div>
    	</div>
    </section>

    </main>


@endsection