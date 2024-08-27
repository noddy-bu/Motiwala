@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')




<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>

<main class="main plans_page">

    <section class="plans_section">
        <div class="container">
            <h4 class="title_heading text-center black_color pb-2 pt-2 heading_font">Plans</h4>
            <div class="row col-md-12 golden_list_diff">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="col-12 p-md-3 p-3 py-2 text-black golden_list golden_treasure" style="background-color:#e3c2ab;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                            <h5 class="mb-0"> {{ env('PLAN_1_NAME') }} </h5>                            
                        </div>
                        <ul class="list-group list-style-circle">
                            <li class="list-group-item py-md-2 py-1">Get Gold in {{ env('PLAN_1') }}</li>
                            <li class="list-group-item py-md-2 py-1">Get Installlment on {{ env('PLAN_1_NAME') }}</li>
                            <li class="list-group-item py-md-2 py-1"><strong>Note:</strong> Gold Reserved as per 22 Karat</li>
                            <div class="col-md-3 col-5  buttonclass mt-md-4 mt-2 mb-3 ms-3">
                                <a href="{{ url(route('account.new.enrollment.page')) }}">Sign Up <i class="las la-arrow-right"></i>
                                </a>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="col-12 p-md-3 p-3 py-2 text-black golden_list golden_fortune`" style="background-color:#e3c2ab;border-top-left-radius: 18px;border-top-right-radius: 18px;">
                            <h5 class="mb-0"> {{ env('PLAN_2_NAME') }} </h5>                            
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item py-md-2 py-1">Get Gold in {{ env('PLAN_2') }}</li>
                            <li class="list-group-item py-md-2 py-1">Get Gold Jewellery on Gold reserved</li>
                            <li class="list-group-item py-md-2 py-1"><strong>Note:</strong> Gold Reserved as per 22 Karat</li>
                        </ul>
                        <div class="col-md-3 col-5  buttonclass mt-md-4 mt-2 mb-3 ms-3">
                            <a href="{{ url(route('account.new.enrollment.page')) }}">Sign Up <i class="las la-arrow-right"></i>
                            </a>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </section>

    	
</main>
@endsection