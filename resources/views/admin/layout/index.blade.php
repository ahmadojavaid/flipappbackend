<!DOCTYPE html>
<html lang="en">
	<head>
		@include('admin.layout.header')
	</head>
	<body>
		 <!-- Begin page -->
        <div id="wrapper">
        	<!--- Top nav bar -->
        		@include('admin.layout.top_nav')
        	<!-- End top navbar  -->

        	<!-- Left Side bar --->
        		@include('admin.layout.sidebar')
        	<!-- End Left Sidebar --->

			<!-- ============================================================== -->
			<!-- Start Page Content here -->
			<!-- ============================================================== -->

		    <div class="content-page">
		        <div class="content">
		        	<div class="container-fluid">
			        	@section('content')
	                	@show
                	</div>
		        </div> 
		        <!-- content -->
		       @include('admin.layout.footer')
		    </div>
		    
			<!-- ============================================================== -->
			<!-- End Page content -->
			<!-- ============================================================== -->
			<!-- Vendor js -->
	        <script src="{{asset('admin/assets/js/vendor.min.js')}}"></script>

	        <!-- Plugins js-->
	        <script src="{{asset('admin/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
	        <script src="{{asset('admin/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>
	        <script src="{{asset('admin/assets/libs/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
	        
	        @section('script')
	        @show
	        
	        <!-- Dashboar 1 init js-->
	        <script src="{{asset('admin/assets/js/pages/dashboard-1.init.js')}}"></script>

	        <!-- App js-->
	        <script src="{{asset('admin/assets/js/app.min.js')}}"></script>
			<script src="{{ asset('assets/js/jquery.buttonLoader.js') }}"></script>

	        <script type="text/javascript">
				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});
				$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

			</script>

		</div>
	</body>
</html>