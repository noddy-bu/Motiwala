@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@php
$url = request()->segment('1');
$page = DB::table('blog_categories')
->where('slug', $url)
->first();
//$count = count($author);
$i = 1;
@endphp

@section('page.title', "$detail->meta_title")

@section('page.description', "$detail->meta_description")

@section('page.type', "$page->name")

@section('page.publish_time', "$detail->updated_at")

@section('page.schema')
<!--------------------------- Page Schema --------------------------------->

<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "{{ url(route('index')) }}"
    }, {
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $page->name }}",
        "item": "{{ url(route(''.$url.'')) }}"
    }, {
        "@type": "ListItem",
        "position": 3,
        "name": "@php echo str_replace('&nbsp;',' ',htmlspecialchars_decode ($detail->title)); @endphp",
        "item": "{{ url()->current() }}"
    }]
}
</script>

@if ($page->name != 'Deal Update')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "{{ $page->name }}Posting",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    },
    "headline": "{{ strip_tags(htmlspecialchars_decode($detail->title)) }}",
    "description": "{{ strip_tags(htmlspecialchars_decode($detail->short_description)) }}",
    "image": "{{ asset('storage/' . $detail->main_image) }}",
    "author": {
        "@type": "Person",
        "name": [
            
            @php $author_name = DB::table('users')-> where('id', $author)->
            first();@endphp "{{ $author_name->name }}",
        ],
        "url": "{{ url('') }}/"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ url('') }}/",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('/assets/frontend/images/logo.png') }}"
        }
    },
    "datePublished": "{{ $detail->updated_at }}"
}
</script>
@endif

<!--------------------------- Page Schema end--------------------------------->
@endsection

@section('page.content')

<!-------================ blog detail start ============ ------------>


<!--Blog Details Banner start-->
<section class="blog_d_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="breadcrumb_heading text-center">
                    {{ $detail->title }}
                </h1>

                <nav aria-label="breadcrumb" class="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active"><a href="{{ url(route('index')) }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ url(route('blog')) }}">Blogs</a>
                        </li>
                        <li class="breadcrumb-item home" aria-current="page">
                            {{ $detail->title }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Banner End-->
<!--Blog Details content start-->
<section class="blog_d_content">
    <div class="container">
        <div class="row">
            <div class="img_btn">
                <img src="{{ asset('storage/' . $detail->main_image) }}" alt="{{ $detail->alt_main_image }}"
                    class="big_img mb-4" />
                <button class="content_btn">
                    {{ $detail->updated_at->format('F j, Y') }}
                </button>
            </div>
            <div class="d-flex align-item-center gap-5 pb-md-3 pb-2" >
                <div>
                    <img src="assets/frontend/images/icon-author.png" alt="" class="me-2" />
                    <span class="">
                        
                        @php
                        $author_name = DB::table('users')
                        ->where('id', $author)
                        ->first();
                        @endphp
                        {{ $author_name->name }} 

                    </span>
                </div>
                <!-- <div>
                    <img src="assets/frontend/images/dot.png" alt="" class="me-2" />
                    <span>{{ $author_name->designation }}</span>
                </div> -->
            </div>
            <hr />
            <div>

                @php echo html_entity_decode($detail->content) @endphp

            </div>

        </div>
    </div>
</section>


<section class="category"  >
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <ul >
                @php
                $category = json_decode($detail->blog_category_ids);
                        @endphp

                        @foreach ($category as $row)
                        @php
                        $category_name = DB::table('blog_categories')
                        ->where('id', $row)
                        ->first()->name;
                        @endphp
                        <li>
                        {{ $category_name }}
                         </li>
                        
                        @endforeach
                   
                </ul>
                <hr>
            </div>
        </div>
    </div>
</section>




<section class="my-box-1 ">
    <div class="container bg-grey py-md-2">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                   <div class="col-md-6">
                   @if ($previous_slug != null)
                    <a
                        href="{{ url(route('blog.detail', ['category' => $url, 'slug' => strtolower(str_replace(' ', '-', $previous_slug))])) }}">
                        <div class="arrow-icons">
                            <img src="assets/frontend/images/arrow-left.png" alt="">
                        </div>
                    </a>
                    @endif
                   </div>
                   <div class="col-md-6 d-flex justify-content-end">
                   @if ($next_slug != null)
                    <a
                        href="{{ url(route('blog.detail', ['category' => $url, 'slug' => strtolower(str_replace(' ', '-', $next_slug))])) }}">
                        <div class="arrow-icons">
                            <img src="assets/frontend/images/arrow-right.png" alt="">
                        </div>
                    </a>
                    @endif
                   </div>

                </div>
            </div>
            <div class="col-6">
                @if ($previous_slug != null)
                <p class="font-size-20"> <b> Your Guide to Free <br class="br" > Open Lawyer Software</b> </p>
                @endif
            </div>
            <div class="col-6">
                @if ($next_slug != null)
                <div class="d-flex justify-content-end text-end">
                    <p class="font-size-20"><b> Your Guide to Free <br class="br" > Open Lawyer Software</b></p>
                </div>
                @endif
            </div>


        </div>

    </div>
</section>
<!--------------------------------=================== comment =========----------->

<section class="comments">
    <div class="container">

        <div class="heading-3">
            <span class="font-size-24">
                <b>Comments</b>
            </span>
        </div>
        @php
        $comment = DB::table('blog_comments')
        ->where('status', 1)
        ->where('blog_id', $detail->id)
        ->orderBy('id', 'desc')
        ->get(); @endphp

        <hr class="m-0">
        @foreach ($comment as $row)
        <div class="py-5">

            <div class="row align-items-center">

                <div class="col-lg-1 col-md-2">
                    <div class="col-space-1">
                        <img src="/assets/frontend/images/Ellipse26.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 px-md-5">
                    <div class="heading-4">
                        <span class="font-size-20">
                            <b>{{ $row->name }}</b>
                        </span>
                    </div>
                    <div class="heading-5">
                        <span class="light-color">
                            {{ date('F d, Y \a\t h:i a', strtotime($row->created_at)) }}
                        </span>
                    </div>
                    <div class="heading-5 pt-md-2">
                        <span class="">
                            {{ $row->comment }}
                        </span>
                    </div>

                </div>

                <div class="col-lg-1 col-md-2">
                    {{-- <button class="content_btn">Reply</button> - --}}
                </div>
            </div>

        </div>
        @endforeach


        <div class="heading-6">
            <span class="font-size-24">
                <b>Post A Comment</b>
            </span>
        </div>
        <div class="heading-6">
            <span class="font-size-20">
                Your email address will not be published *
            </span>
        </div>
        <div class="form-comments">

            @include('frontend.component.comment_form')


        </div>

    </div>

</section>
@include('frontend.component.get_in_touch')

<!----------========= blog detail end ========== ------------------->

@endsection