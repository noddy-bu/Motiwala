@extends('frontend.layouts.app')

@section('page.content')


     <section class="mt-10">
          <div class="success_page padd170">
               <div class="container">
                   <div class="success_box">
                        @php
                            if($temp_user_id != 0){
                                Session()->put('step', 12); 
                                Session()->put('temp_user_id', $temp_user_id);
                            }
                        @endphp
       
                       <h3>Transaction failed due to : {{ $errorMessage }}</h3>
                       <h5>Your order status is <b>{{ $data['status'] }}</b></h5>
                       <h5>Your transaction id for this transaction is <b>{{ $data['txnid'] }}</b></h5>
       
                       <a class="btn btn-primary mt-4 book_new_btn" href="{{ url(route('account.new.enrollment.page')) }}">Back to Payment Page</a>
                   </div>
               </div>
           </div>
     </section>



@endsection