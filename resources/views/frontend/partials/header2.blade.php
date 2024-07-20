    <div class="col-6 dropdown userlogin_box d-md-none d-block">
    
        <div class="login_fa_bars">
            <button id="nav-bar-icon" onclick="openNav()">
                <span class="fa fa-bars"></span>
            </button>
        </div>
        {{-- 
        <a href="#" class="align-items-center text-white text-decoration-none">
            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
            <span class="mx-1 text-dark"><b>{{ ucfirst(auth()->user()->fullname) }}</b></span>
        --}}
        </a>
    </div>
{{-- 
<header class="header_after_sign_in">
    
    

    <div class="col-6">
        <a href="/" class="d-block p-md-3 p-0 link-light" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
           <img class="sidebar_logo" src="/assets/frontend/images/logo.png" > 
        </a>
    </div>
</header> --}}

<script>
    function openNav() {
        var sidebar = document.getElementById("sidebar");
        var bgTheme = document.getElementById("bg_theme");

        if (window.innerWidth <= 991) {
            if (sidebar.style.marginLeft === "-600px") {
                sidebar.style.width = "0";
                bgTheme.style.marginLeft = "-600px";
            } else {
                sidebar.style.width = "250px";
                bgTheme.style.marginLeft = "0px";
            }
        } else {
            if (sidebar.style.marginLeft === "0px") {
                sidebar.style.width = "0";
                bgTheme.style.marginLeft = "-600px";
            } else {
                sidebar.style.width = "250px";
                bgTheme.style.marginLeft = "0px";
            }
        }
    }

    function closeNav() {
        var sidebar = document.getElementById("sidebar");
        var bgTheme = document.getElementById("bg_theme");

        sidebar.style.width = "0";
        bgTheme.style.marginLeft = "-600px";
    }

    // Reset sidebar on window resize
    window.onresize = function() {
        var sidebar = document.getElementById("sidebar");
        var bgTheme = document.getElementById("bg_theme");

        if (window.innerWidth > 991) {
            sidebar.style.width = "250px";
            bgTheme.style.marginLeft = "0px";
        } else {
            sidebar.style.width = "0";
            bgTheme.style.marginLeft = "-600px";
        }
    };

    // Close the sidebar if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('#nav-bar-icon') && !event.target.closest('.bg_theme')) {
            //closeNav();
        }
    }
</script>
