<!--		Side navbar open-->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#" class="text-white"><img src="{{ asset('assets/img/icons/shopping-cart-black-shape.png') }}" class="pr-2"> Buying</a>
    <a href="#" class="text-white"><img src="{{ asset('assets/img/icons/icon.png') }}" class="pr-2"> Selling</a>
    <a href="#" class="text-white"><img src="{{ asset('assets/img/icons/briefcase.png') }}" class="pr-2">Portfolio</a>
    <a href="#" class="text-white"><img src="{{ asset('assets/img/icons/Path%2098.png') }}" class="pr-2">Following</a>
    <a href="#" class="text-white"><img src="{{ asset('assets/img/icons/settings.png') }}" class="pr-2">Settings</a>
    <a href="#" class="text-white"><i class="fas fa-sign-out-alt pr-2"></i>Sign out</a>
</div>
<!--	side navbar end-->
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar" class="shadow side-bar-display">
        <div class="sidebar-header text-center">
            <h3>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
            <div class="d-flex flex-row justify-content-center">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
        </div>

        <ul class="list-unstyled components">


           {{--  <li class="text-center selling-pendin-li">

                <a href="{{route('seller.buying.index')}}" class="text-white {{ (request()->segment(2) == 'buying') ? 'sidebar-active' : '' }} ">
                    <img src="{{ asset('assets/img/icons/shopping-cart-black-shape.png') }}">
                    <br>Buying</a>
            </li>
            <li class="text-center selling-pendin-li">

                <a href="{{route('seller.selling.index')}}" class="{{ (request()->segment(2) == 'selling') ? 'sidebar-active' : '' }} text-white">
                    <img src="{{ asset('assets/img/icons/icon.png') }}">
                    <br>
                    Selling</a>
            </li> --}}
             <li class="text-center selling-pendin-li">

                <a href="{{route('seller.transaction.index')}}" class="text-white {{ (request()->segment(2) == 'transaction') ? 'sidebar-active' : '' }} ">
                    <img src="{{ asset('assets/img/icons/shopping-cart-black-shape.png') }}">
                    <br>Transaction</a>
            </li>
            {{-- <li class="text-center  selling-pendin-li">

                <a href="{{route('seller.portfolio.index')}}" class="{{ (request()->segment(2) == 'portfolio') ? 'sidebar-active' : '' }} text-white">
                    <img src="{{ asset('assets/img/icons/briefcase.png') }}">
                    <br>Portfolio</a>
            </li> --}}
            <li class="text-center  selling-pendin-li">

                <a href="{{route('seller.portfolio.asks')}}" class="{{ (request()->segment(3) == 'asks') ? 'sidebar-active' : '' }} text-white">
                    <img src="{{ asset('assets/img/icons/briefcase.png') }}">
                    <br>Asks</a>
            </li>
            <li class="text-center  selling-pendin-li">

                <a href="{{route('seller.portfolio.bids')}}" class="{{ (request()->segment(3) == 'bids') ? 'sidebar-active' : '' }} text-white">
                    <img src="{{ asset('assets/img/icons/briefcase.png') }}">
                    <br>Bids</a>
            </li>
            <li class="text-center selling-pendin-li">

                <a href="{{route('seller.following.index')}}" class="{{ (request()->segment(2) == 'following') ? 'sidebar-active' : '' }} text-white">
                    <img src="{{ asset('assets/img/icons/Path%2098.png') }}"><br>
                    Following</a>
            </li>
            <li class="text-center  selling-pendin-li">

                <a href="{{route('seller.setting.index')}}" class="{{ (request()->segment(2) == 'setting') ? 'sidebar-active' : '' }} text-white">
                    <img src="{{ asset('assets/img/icons/settings.png') }}"><br>
                    Settings</a>
            </li>
        </ul>


    </nav>
