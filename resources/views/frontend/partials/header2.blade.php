 <div class="dropdown pb-4 userlogin_box">
                <a href="#" class="align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                    <span class="d-none d-sm-inline mx-1 text-dark"><b>{{ ucfirst(auth()->user()->name) }}</b></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" style="z-index: 10000;" >
                    <li><a class="dropdown-item" href="#">Welcome</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('customer.logout') }}">Sign out</a></li>
                </ul>
            </div>