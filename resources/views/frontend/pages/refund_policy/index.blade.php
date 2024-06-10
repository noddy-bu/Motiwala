@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', ' ')

@section('page.description', '  ')

@section('page.type', 'website')

@section('page.content')

<!-- -------------------- privacy start ---------------- -->

<section class="inner_page_banner">
    <img src="/assets/frontend/images/innwe_imagebanner.png" class="d-block w-100" alt="..." >
</section>


    <!-- -------------------- privacy content start ---------------- -->

    <main class="main">
        <section class="pt-5 pb80 terms_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-center black_color pb-0 heading_font pb-3">Refund Policy</h4>
                    </div>
    
                    <div class="col-md-12">
                    
                    </div>
    
                         
            
              </div>
            </div>
        </section>
    </main>

    <!-- -------------------- privacy content  end   ---------------- -->





    @endsection