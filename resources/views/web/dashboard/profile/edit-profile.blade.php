@extends('layouts.dashboard.master')
@section('title', 'Profile')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
		<div class="container">
			<div class="row pb-4">
				<div class="col text-center">
					<p class="mb-0 following-follow-text">PROFILE</p>
				</div>
			</div>
			<div class="row pl-sm-0  ">
				<div class="col">
					<div class="card border-0 shadow rounded-0">

						<div class="card-body">
							<form method="post" action="{{route('seller.profile.update')}}">
								@csrf
								@if (count($errors) > 0)
				                    <div class="alert alert-danger">
				                        <strong>Whoops!</strong> There were some problems with your input.
				                        <ul>
				                            @foreach ($errors->all() as $error)
				                                <li>{{ $error }}</li>
				                            @endforeach
				                        </ul>
				                    </div>
				                @endif
								<div class="form-row">
									<div class="form-group col-md-6">
										<label class="profile-change-password-label">First Name</label>
										<input type="text" name="first_name" value="{{Auth::user()->first_name}}" required="" class="form-control profile-change-password-input">
									</div>
									<div class="form-group col-md-6">
										<label class="profile-change-password-label">Last Name</label>
										<input type="text" name="last_name" value="{{Auth::user()->last_name}}" class="form-control profile-change-password-input">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label class="profile-change-password-label">User Name</label>
										<input type="text" name="user_name" value="{{Auth::user()->user_name}}" class="form-control profile-change-password-input">
									</div>
									<div class="form-group col-md-6">
										<label class="profile-change-password-label">Email</label>
										<input type="email" name="email" value="{{Auth::user()->email}}" class="form-control profile-change-password-input">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label class="profile-change-password-label">Number</label>
										<input type="text" name="phone_number" value="{{Auth::user()->phone_number}}" class="form-control profile-change-password-input">
									</div>
									<div class="form-group col-md-6">
										<label class="profile-change-password-label">Country</label>
										<input type="text" name="country" class="form-control profile-change-password-input" value="{{Auth::user()->country}}">
										{{-- <select id="inputState" class="form-control profile-change-password-input">

											<option>United Kingdom</option>
											<option>China</option>
											<option>USA</option>
										</select> --}}

									</div>
								</div>
							

								<div class="row pt-5 pb-5">
									<div class="col-sm-12 col-md-4">
									</div>
									<div class="col-sm-12 col-md-4">
										<div class="text-center">
											<button class="btn shadow rounded-0 text-white border-0 text-center p-2"
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
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
	<script type="text/javascript">
		
	</script>
@endsection