<div id="header">
    <section class="">
        <nav class="navbar navbar-expand-lg navbar-light text-white header-bg-black header-nav-padding">
            <a class="navbar-brand text-white header-prox-link" href="{{ url('/') }}">PROXX</a>
            <button class="navbar-toggler bg-white text-black-50" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-white header-link" href="{{ route('home') }}">Browse <span class="sr-only">(current)</span></a>
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
                    @if(Auth::check())
                        @if(Auth::user()->email_verified_at)
                        <li class="nav-item">
                            <a class="nav-link text-white header-link"  href="{{ route('seller.dashboard') }}" >Dashboard</a>
                        </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white header-link" href="#"   onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Sign Out</a>
                                <form id="frm-logout" action="{{ url('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white header-link"  href="{{ route('frontend_login') }}">Login/SignUp</a>
                        </li>
                        
                    @endif
                </ul>
            </div>
        </nav>
    </section>
</div>