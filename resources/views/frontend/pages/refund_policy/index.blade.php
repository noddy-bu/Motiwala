@extends('frontend.layouts.app')

@section('page.title', 'Seedling Associates: Top Lawyers &amp; Law Firms in Delhi, India')

@section('page.description', 'Seedling & Associates is one of the best law firms in Delhi, India. We provide legal assistance for startups, FDI, Property law, IP, and more')

@section('page.type', 'website')

@section('page.content')
    <!-- -------------------- blog banner start ---------------- -->

    <section class="blog_banner breadcrumes_padd">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h1 class="breadcrumb_heading">Refund and Cancellation Policy</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb d-flex justify-content-center mb-0">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ url(route('index')) }}" data-aos="fade-up" data-aos-once="true">Home</a>
                                </li>
                                <li class="breadcrumb-item home" aria-current="page">
                                    Refund and Cancellation Policy
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- -------------------- blog banner end   ---------------- -->
    <!-- -------------------- privacy content  start ---------------- -->

    <section class="privacy_content mb-md-3 mb-2 mt-md-5 mt-3">
        <div class="container">
            <div class="row">
                @php echo html_entity_decode(get_settings('refund_policy_content')) @endphp
            </div>
        </div>
    </section>

    <!-- -------------------- privacy content  end   ---------------- -->

    @endsection