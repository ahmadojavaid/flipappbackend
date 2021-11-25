@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
     <div id="content">
		<section class="text-white mt-1" >
			<div class="container">
				<div class="row " >
					<div class="col-sm-12 col-md-8 m-auto" style="background-color: #000000;">
					<div class="row">
						<div class="col">
							<p style="font-size: 28px;padding-left: 4rem;"></p>
						</div>
					</div>
					<div class="row">
						<div class="col text-center">
							<div class="d-flex flex-column justify-content-start">
								<div class="p-2">
									<img src="{{asset('assets/img/icons/Group 456.png')}}" class="img-fluid">
								</div>
								<div class="p-2">
									<p style="font-size: 19px;">Thank You For Your Selling!</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</section>

		<div class="container">
			<div class="row mb-5">
				<div class="col-sm-12 col-md-8 m-auto" style="padding-left: 0px;padding-right: 0px;">
					<section class="" style="background-color: #DCDCDC;">
						<div class="d-flex flex-row justify-content-between">
							<div class="p-2">
								<p class="mb-0">Price</p>
							</div>
							<div class="p-2">
								<p class="mb-0">£ {{$product_sale->sale_price}}</p>
								 
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between">
							<div class="p-2">
								<p class="mb-0">PayPal Protection ({{$setting->value}}%)</p>
							</div>
							<div class="p-2">
								<p class="mb-0">+ £ {{$product_sale->transaction_fee}}</p>
							</div>
						</div>
						{{-- <div class="d-flex flex-row justify-content-between">
							<div class="p-2">
								<p class="mb-0">Discount</p>
							</div>
							<div class="p-2">
								@if($product_sale->coupon_amount)
									<a href="javascript:;" class="text-decoration-none" style="color: #969696;">- £ {{$product_sale->coupon_amount}}</a>
								@else
									<a href="javascript:;" class="text-decoration-none" style="color: #969696;">- £ 0</a>
								@endif
							</div>
						</div> --}}
					</section>
					<div class="d-flex flex-row justify-content-between">
						<div class="p-2">
							<p class="font-weight-bold mb-0">TOTAL:</p>
						</div>
						<div class="p-2">
							<p class="font-weight-bold mb-0" style="font-size: 25px;">£ {{$product_sale->total_amount}}</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row mb-5 mt-5">
				<div class="col-sm-12 col-md-4 text-center m-auto">
					<p style="font-size: 14px;">THANKYOU FOR SELLING A PRODUCT.
						WHILE YOU ARE HERE, WHY NOT CHECK
					</p>
					<a class="text-decoration-none" href="{{route('latest_products')}}" style="color: #2F9855;font-size: 14px;">OTHER PRODUCTS.</a><br>


					 

				</div>
			</div>
		</div>


	</div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
	 
@endsection