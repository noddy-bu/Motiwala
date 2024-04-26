@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', ' ')

@section('page.description',
    'Seedling & Associates is one of the best law firms in Delhi, India. We provide legal
    assistance for startups, FDI, Property law, IP, and more')

@section('page.type', 'blogs')

@section('page.content')

    <!----------------=============== blog start ================------------->
    <!-- -------------------- blog banner start ---------------- -->
    <!--blog banner start -->
    <section class="blog_banner text-center ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="breadcrumb_heading">Latest Blogs</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url(route('index')) }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">
                                Blogs
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!--blog banner end -->

    <!--blog image start -->
    @if(count($blog) > 0)
        <section class="blog_image">
            <div class="container">
                <div class="row" id="blog_data">

                    @include('frontend.component.blog_list_card')



                    {{--
                <div class="col-md-12 ">
                <div
                    class="pagination d-flex align-items-center justify-content-center"
                >
                
                    <ul
                    class="d-flex align-items-center justify-content-center gap-3 list-unstyled"
                    >
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                    <li>4</li>
                    <li><img src="assets/frontend/images/pagination.png" alt="" /></li>
                    </ul> 

                    @if (count($blog) > '5')
                    
                        <button class="footer_btn" id="load-more">View More</button>

                    @endif
                    
                </div>
                </div> --}}


                </div>

                <div class="col-md-12 ">
                    <div class="pagination d-flex align-items-center justify-content-center">

                        @if (count($blog) > '5')
                            <button class="footer_btn" id="load-more">View More</button>
                        @endif

                    </div>
                </div>

            </div>
        </section>
    @endif



    <!--blog image end -->

    <!-------Random Blog Start------------->

    @include('frontend.component.random_blog_list_section')

    <!-------Random Blog End-->


    <!----------------=============== blog end ================------------->
@endsection

@section('component.scripts')
    <script>
        var currentPage = 1; // Track the current page number

        $('#load-more').click(function() {
            currentPage++; // Increment the page number

            $.ajax({
                    url: "{{ route('blog-data') }}",
                    type: 'GET', // Change the method to GET
                    data: {
                        page: currentPage
                    },
                })
                .done(function(response) {
                    if (response.html === '') {
                        $('#load-more').hide(); // Hide the button when there's no more data
                        return;
                    }
                    $('#blog_data').append(response.html);
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
        });
    </script>
@endsection
