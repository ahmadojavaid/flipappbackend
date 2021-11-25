@extends('layouts.homepage.master')
@section('title', 'verification')
@section('content')
<div id="body">

	<form method="post" @if(empty(request()->token)) action="{{route('password.email')}}" @else action="{{route('post.reset-password')}}" @endif>

		@csrf
		<div class="container">
			<div class="row pt-3 ">

				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					@include('flash::message')
					 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					@if ($errors->any())
					    <div class="alert alert-danger" >
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					@if(empty(request()->token))
					<p class="font-weight-bold">Enter Your Email</p>
					@else
						<p class="font-weight-bold">Enter Your Password</p>
					@endif
				</div>
				<div class="col-sm-12 col-md-2">

				</div>
			</div>
			<div class="row p-5">
				<div class="col-sm-12 col-md-2">

				</div>
				@if(empty(request()->token))
				<div class="col-sm-12 col-md-8 text-center">
				
						<div class="form-group">
							<input type="email" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="email"   placeholder="Email">
						</div>

					

				</div>
				@else
				<div class="col-sm-12 col-md-8 text-center">
					<div class="form-group">
							<input type="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="password"   placeholder="Password">
						</div>
						<div class="form-group">
							<input type="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="password_confirmation"   placeholder="Re-Enter Password">
						</div>
					</div>
					<input type="hidden" name="email" value="{{request()->email}}">
					<input type="hidden" name="token" value="{{request()->token}}">
				@endif

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
