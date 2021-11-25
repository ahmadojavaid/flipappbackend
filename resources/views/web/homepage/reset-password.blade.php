@extends('layouts.homepage.master')
@section('title', 'verification')
@section('content')
<div id="body">

	<form method="post" action="{{route('post.reset-password')}}">

		@csrf
		<div class="container">
			<div class="row pt-3 ">

				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					@include('flash::message')
					@if ($errors->any())
					    <div class="alert alert-danger" >
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					<p class="font-weight-bold">Enter Your Password</p>
				</div>
				<div class="col-sm-12 col-md-2">

				</div>
			</div>
			<div class="row p-5">
				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					<form>
						<div class="form-group">
							<input type="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="password"   placeholder="Password">
						</div>
						<div class="form-group">
							<input type="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="password_confirmation"   placeholder="Re-Enter Password">
						</div>

					

				</div>

				<div class="col-sm-12 col-md-2">

				</div>
			</div>

			<div class="row pb-5" style="padding-top: 6rem;">
				<div class="col text-center">
					<button type="submit" class="btn btn-dark rounded-0 border-0 mt-4 mb-5" style="width: 10rem;">Send</button>
				</div>
			</div>
		</div>
		</form>
	</div>

@endsection
@section('cssheader')
@endsection
@section('jsfooter')
 
@endsection
