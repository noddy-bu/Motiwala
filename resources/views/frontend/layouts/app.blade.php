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

        @include('frontend.partials.header')

    <!---========end Header======----->

    <!---======== page content ====-------->

        @yield('page.content')

    <!---======== page content ===== -------->

    <!-----------------------Footer Start------------------------------------------->

        @include('frontend.partials.footer')

    <!--Footer Ends-->


    <!--javascript-->
    @include('frontend.partials.js')
    @yield('page.scripts')
    @yield('component.scripts')
    @yield('login.scripts')

    @yield('forgot.scripts')


    <div class="whatsappdesktop">
    <a target="_blank" href="https://api.whatsapp.com/send?phone=+919920077780&amp;text=Hi%2C+I+am+contacting+you+through+your+website+https://treasure.motiwalajewels.in%2F">
    <i aria-hidden="true" class="lab la-whatsapp"></i>
    </a>
</div>

<div class="calltoaction">
    <a target="_blank" href="tel:+91 9920077780">
   <i class="las la-phone"></i>
    </a>
</div>

</body>

</html>