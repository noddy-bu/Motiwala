<!DOCTYPE html>
<html lang="en">

<head>

    <!----------Meta Information---------->
    @include('frontend.partials.meta')

    <!-----------Stylesheets------------>
    @include('frontend.partials.css')

</head>

<body id="index" class="after_login_body">

    <!---========Header======----->

        @include('frontend.partials.header2')

    <!---========end Header======----->
    <!---========sidebar======----->

        @include('frontend.partials.sidebar')

    <!---========end sidebar======----->

    <!---======== page content ====-------->

        @yield('page.content')

    <!---======== page content ===== -------->

    <!-----------------------Footer Start------------------------------------------->
        @include('frontend.partials.footer2')

     <!-----------------------Footer end------------------------------------------->

            </div>
        </div>
    </div>

    <!--Footer Ends-->


    <!--javascript-->
    @include('frontend.partials.js')
    @yield('page.scripts')
    @yield('component.scripts')
    @yield('login.scripts')

</body>

</html>