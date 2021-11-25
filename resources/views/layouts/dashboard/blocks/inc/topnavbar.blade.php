<div id="header">
    <section class="">
        <nav class="navbar navbar-expand-lg navbar-light text-white header-bg-black header-nav-padding">
            <a class="navbar-brand text-white header-prox-link" href="#">PROXX

            </a>
            <button class="navbar-toggler bg-white text-black-50" type="button">
                <!--					<span class="navbar-toggler-icon"></span>-->
                <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-white header-link" href="{{ url('/') }}">Browse <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white header-link" href="{{ url('/news') }}">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white header-link" href="{{route('get_app')}}">App</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white header-link" href="{{url('/terms-and-conditions')}}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white header-link" href="{{route('seller.profile.index')}}">My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white header-link" href="#"   onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Sign Out</a>
                        <form id="frm-logout" action="{{ url('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>



                </ul>

            </div>
        </nav>
        <div class="header-bg-black">

        </div>
        <nav class="navbar navbar-expand-lg navbar-light text-white header-bg-black header-nav-padding" style="margin-top: -23px;">
            <form>
                <div class="input-group mb-3 search-box">
                    <input type="text" class="form-control border-0 rounded-0 shadow-none " placeholder="SEARCH FOR BRAND" aria-label="SEARCH FOR BRAND"
                           aria-describedby="basic-addon2">
                    <div class="input-group-append">

							<span class="input-group-text index-search-btn border-0" id="basic-addon2"><img src="{{ asset('assets/img/icons/Line 92.png') }}"
                                                                                                            style="height: 20px;padding-right: 12px;"><i
                                        class="fas fa-search"></i></span>
                    </div>
                </div>
            </form>


        </nav>
    </section>

</div>