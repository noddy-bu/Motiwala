@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', ' ')

@section('page.description', '  ')

@section('page.type', 'website')

@section('page.content')

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>

<!--  ----------------- Thank You --------------------- -->

<main class="main">
    <section class="thankyou_page pd80 bg_image2 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 thank_you py-5">
                    <h3 class="thankyou_hed">Thank You!</h3>
                    <h5 class="thankyou_hed1">For Contacting Us!</h5>
                    <p class="thanks_para mb-3">We will reach you out immediately</p>
                    <div class="mt-4 buttonclass" >
                    <a class="backhomebutton " href="{{ url(route('index')) }}">Back to Home Page</a>
                    </div>
                </div>
            </div>  
        </div>
    </section>
</main>




<!--  ----------------- thank you End --------------------- -->


@endsection