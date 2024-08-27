@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', 'Motiwala')

@section('page.description', 'Motiwala')

@section('page.type', 'website')

@section('page.content')




<!-- -------------------- career banner start ---------------- -->

<section class="inner_page_banner">
     <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="...">
</section>

<main class="main">

    <section class="faq_section_main">
        <div class="container">
            <h4 class="title_heading text-center black_color pb-2 pt-2 heading_font">Frequently Asked Questions</h4>
            
        </div>
    </section>

    	
</main>
@endsection