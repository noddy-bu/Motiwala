<div class="container-fluid">
    <div class="row">

        <div class="col-sm-auto bg-light sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">

                <a href="/" class="d-block p-3 link-light text-decoration-none" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
                    <img  src="{{ asset('/assets/frontend/images/logo.png') }}">
                </a>

                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start mx-1" id="menu">

                    <li class="nav-item">
                        <a href="{{ url(route('information')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Information</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('index')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Pay Installments</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('index')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Manage A/c & Benefits</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('terms')) }}#autodebit_modal" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Auto Debit</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('terms')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Cancel ACH / Auto Debit (SI)</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('terms')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Manage Profile</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('terms')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Group Account</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('terms')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Old Scheme Closure</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('terms')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">Terms and Conditions</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url(route('faq')) }}" class="nav-link align-middle px-0">
                            <i class="la la-info"></i> <span class="ms-1 d-none d-sm-inline">FAQ</span>
                        </a>
                    </li>

                    <hr>
                </ul>



            </div>
        </div>
        <div class="col-sm p-3 min-vh-100">


