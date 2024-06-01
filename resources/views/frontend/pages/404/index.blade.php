@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', ' ')

@section('page.description', '  ')

@section('page.type', 'website')

@section('page.content')


<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>

<!--  ----------------- 404 start --------------------- -->


<section class="404">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container_404 d-flex align-items-center justify-content-center flex-column">
                    <h2>404</h2>
                    <h4>Something’s missing?..</h4>
                    <p>This page is missing or you assembled the link incorrectly.</p>
                    <button>Go to Website</button>
                </div>
            </div>
        </div>
    </div>
</section>




<!--  ----------------- 404 End --------------------- -->



@endsection