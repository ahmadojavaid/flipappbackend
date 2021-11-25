@extends('layouts.homepage.master')
@section('title', 'verification')
@section('content')
<div id="body">
		<div class="container">
			<div class="row pt-3 ">
				
				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					 @include('flash::message')
					<!-- <div class="alert alert-success " role="alert">
                    We have Send the Verification code, please paste your code here for complete SignUp       
                </div> -->
					<p class="font-weight-bold">Please enter the code, sent code on Email</p>
				</div>
				<div class="col-sm-12 col-md-2">

				</div>
			</div>
			<form method="post" action="{{route('submit_verification_code')}}">
				@csrf
			<div class="row p-5">
				<div class="col-sm-12 col-md-2">

				</div>
				
				<div class="col-sm-12 col-md-8 text-center">
					
						<div class="form-group">
							<input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="code"  placeholder="Enter Code" required>
						</div>


					
					<section class="text-center p-3 mt-4 mb-5" style="background-color: #F6F6F6;">
						<p>If you do not receive the code.</p>
						<a href="{{route('re_code_verification')}}" class="font-weight-bold h5 text-decoration-none" style="color: #2F2F2F;border-bottom: 2px #2F2F2F solid">RESEND CODE</a>

					</section>
				</div>

				<div class="col-sm-12 col-md-2">

				</div>
			</div>

			<div class="row pb-5" style="">
				<div class="col text-center">
					<button type="submit" class="btn btn-dark rounded-0 border-0 mt-4 mb-5" style="width: 10rem;">SAVE</button>
				</div>
			</div>
			</form>
		</div>
	</div>

@endsection
@section('cssheader')
@endsection
@section('jsfooter')
 
@endsection
