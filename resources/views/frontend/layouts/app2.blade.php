<!DOCTYPE html>
<html lang="en">

<head>

    <!----------Meta Information---------->
    @include('frontend.partials.meta')

    <!-----------Stylesheets------------>
    @include('frontend.partials.css')

</head>

<body id="index">

    <!---========Header======----->

        @include('frontend.partials.sidebar')

    <!---========end Header======----->

    <!---======== page content ====-------->

        @yield('page.content')

    <!---======== page content ===== -------->

    <!-----------------------Footer Start------------------------------------------->

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