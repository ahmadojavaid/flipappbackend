@extends('layouts.dashboard.master')
@section('title', 'Transaction')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
		<div class="container">
			<div class="row">
				<div class="col">
					@include('flash::message')
					<nav class=" side-bar-display col-md-3" style="padding: 0px; margin-top: 215px">
						<ul class="list-unstyled components" id="pills-tab" role="tablist">						<li class="text-center  selling-pendin-li mb-3 p-3" style="background: #000000; padding: 0px; margin: 0px;">

				                <a href="{{route('seller.buying.index')}}" style="display: block"  class="{{ (request()->segment(3) == 'bids') ? 'sidebar-active' : '' }} text-white">
				                    <img src="{{ asset('assets/img/icons/shopping-cart-black-shape.png') }}">
				                    <br>Buying</a>
				            </li>
				            <li class="text-center  selling-pendin-li mb-3 p-3" style="background: #000000; padding: 0px; margin: 0px;">

				                <a href="{{route('seller.selling.index')}}" style="display: block"   class="{{ (request()->segment(3) == 'bids') ? 'sidebar-active' : '' }} text-white">
				                    <img src="{{ asset('assets/img/icons/icon.png') }}">
				                    <br>Selling</a>
				            </li>
							 
							
						</ul>
					</nav>
					
				</div>
			</div>
		</div>
	</div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
