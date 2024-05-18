
@extends('web.layouts.app')

@section('main.content')
<body>
	
	<div class="success_page">
    <div class="container">
	
	<div class="success_box">
	<img src="{{url('assets/thank_you.png')}}">
	
	<h3 class="mb-0 text-center"><strong class="text-danger"> Registration No</strong> : SIEINDIA{{auth()->guard('web')->user()->id}}</h3>
		
    <h3>Thank You. Your order status is {{$status}}.</h3>
    <h4>Your Transaction ID for this transaction is <b>{{$txnid}}</b></h4>
	@if($amount > 0)
    <h5>We have received a payment of Rs. <b>{{$amount}}</b></h5>
	@endif
    
    <h2>Booking Information <b>({{$order->d1}})</b></h2>
		<div class="table-responsive">
		<table class="table paddbotm20">
	   <tbody>
		   
           <tr>
		      <th width="10%"><b>Sr. No.</b></th>
			   <th width="10%"><b>Name</b></th>
			    <th width="15%"><b>Speaker</b></th>
			    <th width="30%"><b>Topics</b></th>
		      
		      <th width="20%"><b>Date</b></th>
			  <th width="15%"><b>Timing</b></th>
			  <th width="20%"><b>Amount</b></th>
		     
		     
		  </tr>
		   @php
		     $sr = 1;
		   @endphp
		   @foreach($order_items as $item)
		   <tr>
		      <td>{{$sr++}}</td>
			   <td>{{$item->slot_name}}</td>
			   <td>{{$item->speaker}}</td>
			   <td>{{$item->description}}</td>
		      
		      <td>
				{{date('d F Y', strtotime($item->slot_date))}}, {{date('l', strtotime($item->slot_date))}}				
			</td>
			<td>{{$item->slot_time}}</td>
			  <td>₹{{$item->amount}}</td>
		      
		      
		  </tr>
    @endforeach
		   
	      
		  
		  
		  
	   </tbody>
	</table>
			
			
			<a class="btn btn-primary mt-4 book_new_btn" href="{{url('')}}">Back to Home Page</a>
    </div>
 </div>
  </div>
  </div>

</body>
@endsection

@section('main.script')
<script>

</script>
@endsection
