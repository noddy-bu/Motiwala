<div id="bg_theme" class="col-md-3 col-7 width20 bg-light bg_theme">
    <div id="sidebar" class="d-flex sidebar width80">
        <a href="/" class="d-md-block d-none p-md-3 p-0 link-light" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
            <img class="sidebar_logo" src="/assets/frontend/images/logo.png">
        </a>
        <a class="closebtn" onclick="closeNav()">
            <i class="fa fa-xmark"></i>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start px-2 pt-md-3 pt-5" id="menu">
            <li class="nav-item">
                <a href="{{ url(route('information')) }}" class="nav-link align-middle px-0">
                    <i class="las la-exclamation-circle"></i>
                    <span class="ms-1 d-sm-inline">Information</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url(route('pay-installments')) }}" class="nav-link align-middle px-0">
                    <i class="las la-hand-holding-usd"></i>
                    <span class="ms-1 d-sm-inline">Pay Installments</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ url(route('customer.myaccounts')) }}" class="nav-link align-middle px-0">
                    <i class="las la-user-plus"></i>
                    <span class="ms-1 d-sm-inline">Manage A/c &amp; Benefits</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url(route('customer.get-si-account-nos')) }}" class="nav-link align-middle px-0">
                    <i class="las la-credit-card"></i>
                    <span class="ms-1 d-sm-inline">Auto Debit</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url(route('customer.cancel-ach-si')) }}" class="nav-link align-middle px-0">
                    <i class="lab la-cc-mastercard"></i>
                    <span class="ms-1 d-sm-inline">Cancel ACH / Auto Debit (SI)</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="{{ url(route('edit-user-profile')) }}" class="nav-link align-middle px-0">
                    <i class="las la-user-circle"></i>
                    <span class="ms-1 d-sm-inline">Manage Profile</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="/linkaccount" class="nav-link align-middle px-0">
                    <i class="las la-user-friends"></i>
                    <span class="ms-1 d-sm-inline">Group Account</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="{{ url(route('old-scheme-closure')) }}" class="nav-link align-middle px-0">
                    <i class="las la-file-invoice"></i>
                    <span class="ms-1 d-sm-inline">Old Scheme Closure</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/terms-conditions" class="nav-link align-middle px-0">
                    <i class="las la-clipboard-list"></i>
                    <span class="ms-1 d-sm-inline">Terms and Conditions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url(route('faq')) }}" class="nav-link align-middle px-0">
                    <i class="las la-question-circle"></i>
                    <span class="ms-1 d-sm-inline">FAQ</span>
                </a>
            </li>
            <hr>
        </ul>
    </div>
</div>

<div class="container-fluid sidebaar_section">
    <div class="">

        
        <div class="col-md-9 width80 p-3 min-vh-100">


