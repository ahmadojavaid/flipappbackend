@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('re-product-add') }}
 
<div class="card">
    <div class="card-body">
<form method="post" action="{{route('admin.release_product.store')}}" id="form_sub"  enctype="multipart/form-data">
	
		
	     
	        
	                <h4 class="mb-3 header-title"></h4>
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
	                
	                    @csrf
	                    <div class="alert alert-danger  hide error_msgs" role="alert">
                                          
                                        </div>
                                       <div class="alert alert-success hide success_msgs" role="alert">
                                           
                                        </div>
	                    <div class="row">

		                    <div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputEmail1">Brand</label>
			                        <select class="selectpicker" id="brand_name" name="brand_name" data-style="btn-light">
			                            @foreach($brands as $brand)
			                            	<option value="{{$brand->id}}">{{$brand->brand_name}}</option>
			                            @endforeach
			                        </select>	
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Product Name</label>
			                        <input type="text" id="product_name" name="product_name" class="form-control">
			                    </div>
		                	</div>
	                	</div>
	                	<div class="row">
		                    {{-- <div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Condition</label> 
			                        <select class="selectpicker" id="condition" name="condition" data-style="btn-light">
			                            
			                            	<option value="old">Old</option>
			                            	<option value="new">New</option>
			                           
			                        </select>
			                    </div>
		                	</div> --}}
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Color Way</label>
			                        <input type="text" id="color_way" name="color_way" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Style</label>
			                        <input type="text" id="style" name="style" class="form-control">
			                    </div>
		                	</div>
	                	</div>
	                	<div class="row">
		                    
		                	<div class="col-lg-8">

		                		<div class="form-group">
		                			<label for="exampleInputPassword1">Sizes</label>
		                            		<div class="row p-40">
		                            			@if($product_type)
		                            				@if($product_type->productTypeSize)
		                            					@foreach($product_type->productTypeSize as $key => $size)
			                                                <div class="custom-control col-lg-6 custom-checkbox mb-2 " >
			                                                	<div class="row">
				                                                	<div class="col-lg-2">
										                                <input type="checkbox" class=" size custom-control-input sel_checkbox" value="{{$size->id}}"  name="size[]"   id="autoSizingCheck{{$size->id}}">
										                                <label class="custom-control-label"  for="autoSizingCheck{{$size->id}}">{{$size->name}}</label>
									                            	</div>
									                            	<div class="col-lg-8 all_retail_price hide">
									                            		<input type="number" placeholder="Retail Price" name="size[]" class="form-control  " />
									                            	</div>
								                            	</div>
								                            </div>
							                            @endforeach
						                            @endif
					                            @endif
					                           
                                            </div>
		                		</div>
		                	</div>

	                	</div>
	                	<div class="row">
	                		<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Publish Date</label>
			                        <input type="date" id="publish_date" name="publish_date" class="form-control">
			                    </div>
		                	</div>
	                	</div>
	                	
	                    
	                    <!-- <div class="m-t-20">
	                        <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
	                    </div> -->
 						<div class="row ">
			    <div class="col-12">
			        <div class="card">
			            <div class="card-body dropzone">
			                <div class="dropzone" id="myAwesomeDropzone">
			                    <div class="fallback dddfff">
			                        <input name="file" type="file" multiple />
			                    </div>

			                    <div class="dz-message needsclick">
			                        <i class="h1 text-muted dripicons-cloud-upload"></i>
			                        <h3>Drop files here or click to upload.</h3>
			                    </div>
			                </div>  
			            </div>  
			        </div> 
			    </div> 
			</div>
			<div class="m-t-20">
			<button type="submit" id="submit-all" class="btn btn-primary waves-effect waves-light has-spinner">Submit</button>
			</div>
</form>
<!-- <div class="row dropzone">
    <div id="myAwesomeDropzone" class="col-lg-12" >
        <div class="fallback">
            <input type="file" name="file[]" multiple="" class="display-none" />
        </div>
        <div class="dz-message needsclick">
            <i class="h1 text-muted dripicons-cloud-upload"></i>
            <h3>Drop files here or click to upload.</h3>
        </div>
	</div>
	 
</div> -->




			 


 





</div> <!-- end card-body-->
	        </div> <!-- end card-->
<!-- container -->
@endsection
@include('admin.js-css-blades.bootstrap-select')
@include('admin.js-css-blades.dropzone')
@include('admin.js-css-blades.flat-datepicker')
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#publish_date').flatpickr({
				minDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
			});
			 $('.error_msgs').addClass('hide');
        	$('.success_msgs').addClass('hide');
			var dzClosure;
			$("div#myAwesomeDropzone").dropzone({ 
				url: "{{route('admin.release_product.store')}}",
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
			    },

				autoProcessQueue: false,
			    uploadMultiple: true,
			    parallelUploads: 5,
			    maxFiles: 5,
			    maxFilesize: 1,
			    acceptedFiles: 'image/*',
			    addRemoveLinks: true,
			    init: function() {
		        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

		        // for Dropzone to process the queue (instead of default form behavior):
		        document.getElementById("submit-all").addEventListener("click", function(e) {
		            // Make sure that the form isn't actually being sent.
		            e.preventDefault();
		            e.stopPropagation(); 
		            //var formData = new FormData();
		            // a =  dzClosure.files;
		            // console.log(dzClosure); 
		            jQuery("#form_sub").submit();
		            //dzClosure.processQueue();
		        });

		        //send all the form data along with the files:
		        this.on("sendingmultiple", function(data, xhr, formData) {
		        	 return false;
		        	 //console.log('jh');
		            // formData.append("product_name", jQuery('#product_name').val()); 
		            // formData.append("product_name", jQuery('#brand_name').val());
		            // formData.append("condition", jQuery('#condition').val());
		            // formData.append("style", jQuery('#style').val());
		            // formData.append("color_way", jQuery('#color_way').val());
		            // formData.append("size", jQuery('.size').val()); 
		             
		        });
		    }
     		});
     		jQuery("#form_sub").submit(function(e){
	     			e.preventDefault();
	     			$('.has-spinner').buttonLoader('start');               
     			$('.spinner').removeClass('spinner');
           			 $('.error_msgs').addClass('hide');
	     			 
	     		  
	     			var fd = new FormData();
	     			fd.append("brand_name", $('#brand_name').val()); 
	     			fd.append("product_name", $('#product_name').val());  
		            fd.append("condition", $('#condition').val());
		            fd.append("style", $('#style').val());
		            fd.append("color_way", $('#color_way').val());
		            fd.append('publish_date',$('#publish_date').val());
		            
		            var myCheckboxes = new Array();
					$('.size').each(function() {
						if($(this).prop("checked") == true){
						   // myCheckboxes.push($(this).val());
						   myCheckboxes.push($(this).val()+'_'+$(this).parent().next('.all_retail_price').children('input').val()); 
						}
					});
					//  var retailPrice = new Array();
					// $('.size').each(function() {
					// 	if($(this).prop("checked") == true){
					// 	   // myCheckboxes.push($(this).val());
					// 	   if($(this).parent().next('.all_retail_price').children('input').val()){
					// 	   	alert(2);
					// 	   }
					// 	}
					// });
		            fd.append("size", myCheckboxes);
		            $.each(dzClosure.files,function(index,value){
		            	console.log(value);

		            	fd.append("files[]", value);
		            });
		            // fd.append("files", dzClosure.files);
		             
		            
		            $.ajax({
		                url     : "{{route('admin.release_product.store')}}",
		                method  : 'post',
		                data    : fd,
		                processData: false,
		    			contentType: false,
		                success : function(response){
		                    // $('.success_msgs').removeClass('hide');
		                    $('.error_msgs').addClass('hide');
                    		$('.has-spinner').buttonLoader('stop');
		                    if(response.status == 1){ 
		                        window.location = response.url; 
		                    }
		                    if(response.status == 0){  
		                        $('.error_msgs').html('<ul><li>'+response.message+'</li></ul>');
		                    }
		                },
		                error: function (reject) {
		                if( reject.status === 422 ) {
		                	 var errors = $.parseJSON(reject.responseText);
		                    var hh = '<ul class="float_left">';
		                    $.each(errors.errors, function (key, val) {
		                        hh += '<li>' + val + '</li>';
		                    });
		                    hh += '</ul>';
		                    $('.error_msgs').html(hh);
		                    $('.error_msgs').removeClass('hide');
                    		$('.has-spinner').buttonLoader('stop');
		                    $('.success_msgs').addClass('hide');
		                }
		            }
	            });
     		});

     		$('.sel_checkbox').change(function(){
     			if($(this).is(":checked")){
     				$(this).parent().next('.all_retail_price').show();
     			}else{
     				$(this).parent().next('.all_retail_price').hide();
     				$(this).parent().next('.all_retail_price').children('input').val('');
     			}
     		})


     		// $("#submit-all").click(function(e){
       //      e.preventDefault(e);
       //      $('.error_msgs_signin').addClass('hide');
       //      
       //  });
		});
	</script>
@endsection
