@extends('layouts.dashboard.master')
@section('title', 'Profile')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
		<div class="container">
			<div class="row pb-4">
				<div class="col">
					<p class="mb-0 following-follow-text">PROFILE</p>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="card border-0 shadow rounded-0">
						<div class="card-header">
							<div class="row">
								<div class="col text-right">
									<a href="{{route('seller.profile.edit')}}">
										<img src="{{asset('assets/img/icons/pencil-edit-button%20(1).png')}}">
									</a>
								</div>
							</div>
							<div class="row">
								<div class="col text-center">
									<h3>{{ucfirst(Auth::user()->first_name)}} {{ucfirst(Auth::user()->last_name)}}</h3>
									<div class="d-flex flex-row justify-content-center">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							@include('flash::message')
							
								<div class="form-row">
									<div class="form-group col-md-6">
										<label class="delivery-address-form-label">User Name</label>
										<input type="text" readonly class="shadow-none form-control delivery-address-form-input"
											  value="{{Auth::user()->user_name}}">
									</div>
									<div class="form-group col-md-6">
										<label class="delivery-address-form-label">Country</label>
										<input type="text" readonly class="shadow-none form-control delivery-address-form-input"
											  value="{{Auth::user()->country}}">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label class="delivery-address-form-label">Email</label>
										<input type="email" readonly class="shadow-none form-control delivery-address-form-input" value="{{Auth::user()->email}}">
									</div>
									<div class="form-group col-md-6">
										<label class="delivery-address-form-label">Number</label>
										<input type="text" readonly class="shadow-none form-control delivery-address-form-input" value="{{Auth::user()->phone_number}}">
									</div>
								</div>
							<a class="text-decoration-none font-weight-bold" style="background: transparent;color: #9F9F9F" data-toggle="collapse"
							   href="#collapseExample" role="button" aria-expanded="false"
							   aria-controls="collapseExample">
								CHANGE PASSWORD
							</a>
							<div class="collapse @if (count($errors) > 0) show @endif" id="collapseExample">

								<div class="card card-body mt-3 border-0 rounded-0 shadow" style="background-color: #F5F5F5;">
									
									<form action="{{route('seller.profile.change_password')}}" method="post">
										@csrf
										<div class="row">
											<div class="col-sm-12 col-md-4 offset-md-4">
												@if (count($errors) > 0)
													<div class="alert alert-danger errors-container">
													  <ul>
				 										@foreach($errors->all() as $error)
													      <li> {{ $error }}</li>
													    @endforeach
													  </ul>
													</div>
												@endif
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-4">

											</div>
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label class="profile-change-password-label">Old Password</label>
													<input type="password"  required="" name="old_password" class="form-control profile-change-password-input">
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-4">

											</div>
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label class="profile-change-password-label">New Password</label>
													<input type="password" required="" name="password" class="form-control profile-change-password-input">
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-4">

											</div>
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label class="profile-change-password-label">Confirm Password</label>
													<input type="password" required="" name="password_confirmation" class="form-control profile-change-password-input">
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 col-md-4">
											</div>
											<div class="col-sm-12 col-md-4">
												<div class="text-center">
													<button type="submit" class="btn shadow rounded-0 text-white border-0 text-center p-2"
														   style="width: 10rem;background-color: #2F2F2F;">SAVE
													</button>
												</div>
											</div>
											<div class="col-sm-12 col-md-4">
											</div>
										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
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