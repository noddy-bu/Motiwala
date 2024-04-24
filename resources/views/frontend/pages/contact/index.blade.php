@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Seedling Associates: Top Lawyers &amp; Law Firms in Delhi, India')

@section('page.description',
    'Seedling & Associates is one of the best law firms in Delhi, India. We provide legal
    assistance for startups, FDI, Property law, IP, and more')

@section('page.type', 'website')

@section('page.content')

    <!----------========== contact start ===============-------------------->

    <!-- ---------------------- Contact banner start ---------------- -->

    <section class="contact_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <h1 class="breadcrumb_heading text-center">Contact Us</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ url(route('index')) }}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">
                                    Contact Us
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------------- Contact banner End ---------------- -->
    <!-- ---------------------- Contact process start ---------------- -->

    <section class="contact_process">
        <div class="container">
            <div class="row">
                <div class="col-xl-7">
                    <h2 class="color_heading">Payment Process</h2>
                    <h4 class="main_heading">{{ get_contactpage('p_title') }}</h4>
                    <p class="desc text_justify">{{ get_contactpage('p_description') }}</p>

                    <div class="ms-4 mt-5">
                        <div class="main-timeline">
                            @php 
                            $i = 1; 
                            $step_bar = json_decode(get_contactpage('steps'), true);
                            @endphp
                    
                            @foreach ($step_bar as $innerArray)
                                @foreach ($innerArray as $title => $description)    
                                    <div class="timeline">
                                        <a href="#" class="timeline-content">
                                            <div class="timeline-icon">
                                                @if($i != '2' && $i != '4') <!-- Use && instead of || -->
                                                    <img src="{{ asset('assets/frontend/images/p_' . $i . '.png') }}" alt="" />
                                                @else
                                                    <img src="{{ asset('assets/frontend/images/a_' . $i . '.png') }}" alt="" />
                                                @endif
                                            </div>
                                            <h5 class="description">
                                                {{ $title }}
                                            </h5>
                                            <p class="text_justify" >{{ $description }}</p>
                                        </a>
                                    </div>
                                    @php $i++; @endphp 
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="col-xl-5">
                    <h3 class="color_heading mb-1" data-aos="fade-up" data-aos-once="true">
                        CONTACT US
                    </h3>
                    <h2 class="main_heading mb-3" data-aos="fade-up" data-aos-once="true">
                        Contact Information
                    </h2>
                    <div class="contact_icon_box">
                        <div class="row">
                            <div class="col-md-6 mb-md-0 mb-4">
                                <a href="https://maps.app.goo.gl/AzUYjhttgB6Ytswf7" class="contact_icon_container d-flex align-items-center justify-content-center flex-column gap-md-4 gap-2 text-center"
                                    data-aos="fade-up" data-aos-once="true">
                                    <img src="assets/frontend/images/loaction.png" class="contact_icon" alt="Contact Icon" />
                                    <p class="contact_title">Location</p>
                                    <p class="desc mb-0">
                                        {{ get_contactpage('location') }}
                                    </p>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="contact_icon_container d-flex align-items-center justify-content-center flex-column gap-md-4 gap-2 text-center"
                                    data-aos="fade-up" data-aos-once="true">
                                    <img src="assets/frontend/images/call_big.png" class="contact_icon" alt="Contact Icon" />
                                    <p class="contact_title">24/7 Support</p>
                                    <div>
                                    <a  class="desc mb-0" href="tel:+91-74288 99959">
                                    +{{ get_contactpage('number') }}
                                    </a>
                                    <a class="desc mb-0" href="mailto:admin@seedlingassociates.com">
                                    {{ get_contactpage('email') }}
                                    </a>
                                   
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="contact_rating_container d-flex align-items-center flex-md-row flex-column gap-2 mt-4" data-aos="fade-up"
                            data-aos-once="true">
                            <div class="title">
                                Our Best Skilled Attorneys, Trust Score 5.0
                            </div>
                            <div class="icon">
                                <img src="assets/frontend/images/stars.png" alt="" />
                            </div>
                        </div>

                        <div class="payment_box">
                            @php
                                $practice_Area = DB::table('practice_areas')->orderBy('id', 'asc')->get();
                            @endphp

                            <form>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option value="">Select the Service</option>
                                    @foreach ($practice_Area as $row)
                                        <option value="{{ $row->title }}">{{ $row->title }}</option>
                                    @endforeach
                                </select>


                                <div class="radio_container">
                                    <input type="radio" name="radio" id="one" checked />
                                    <label for="one"> <span class="price" >
                                    ₹{{ get_contactpage('p_20') }}
                                    </span> for 20 mins</label>
                                    <input type="radio" name="radio" id="two" />
                                    <label for="two"> <span class="price" >
                                    ₹{{ get_contactpage('p_40') }}
                                    </span>  for 40 mins</label>
                                </div>




                            </form>
                            <!-- <label for="699" class="price_list">
    <h4>₹699 <span>for 20 mins</span></h4>
</label>
<input type="radio" id="699" name="price" hidden>

<label for="999" class="price_list">
    <h4>₹999 <span>for 40 mins</span></h4>
</label>
<input type="radio" id="999" name="price" hidden> -->
                            <p class="desc">
                                {{ get_contactpage('f_description') }}
                            </p>

                            <div class="text-center mt-4 mb-4">
                                <a class="backhomebutton" href="#">
                                    BOOK CONSULTATION
                                </a>
                            </div>
                        </div>
                        
       <style>
           .payment_button {
    background-color: #e13333 !important;
    color: #f1f3f5;
    font-weight: 900;
    transition: 0.3s;
    padding: 5px 50px;
    margin-bottom: 20px;
    border-radius: 40px 0px 40px 0px;
    text-align: center;
    cursor: pointer;
    font-size: 33px !important;
    border: 0px !important;
}

.payment_button span {
    font-size: 16px;
}
       </style>                 
                         <div class="payment_box">
                             <p>Payment Process</p>
                             
                             <!-- Button trigger modal -->
<button type="button" class="btn btn-primary payment_button" data-bs-toggle="modal" data-bs-target="#iframe_modal_first">
  ₹699 <span>for 20 mins</span>
</button>

<!-- Modal -->
<div class="modal fade iframe_modal" id="iframe_modal_first" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe src="https://easebuzz.in/quickpay/jolsprknwp" class="iframe_popup" frameborder="0"></iframe>

      </div>
     
    </div>
  </div>
</div>
                         </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------------- Contact process End ---------------- -->

    <!-------------=============== contact end =============== -------------------->

@endsection
