@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('re-product-edit',$product->id) }}
 
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
			                            	<option {{($product->brand_id == $brand->id) ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->brand_name}}</option>
			                            @endforeach
			                        </select>	
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Product Name</label>
			                        <input type="text" id="product_name" value="{{$product->product_name}}" name="product_name" class="form-control">
			                    </div>
		                	</div>
	                	</div>
	                	<div class="row">
		                   {{--  <div class="col-lg-6">
			                    <div class="form-group">  
			                        <label for="exampleInputPassword1">Condition</label> 
			                        <select class="selectpicker" id="condition" name="condition" data-style="btn-light">
			                            
			                            	<option {{($product->condition == 'old') ? 'selected' : ''}} value="old">Old</option>
			                            	<option {{($product->condition == 'new') ? 'selected' : ''}} value="new">New</option>
			                           
			                        </select>
			                    </div>
		                	</div> --}}
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Color Way</label>
			                        <input type="text" id="color_way" name="color_way" value="{{$product->color_way}}" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Style</label>
			                        <input type="text" id="style" name="style" value="{{$product->style}}" class="form-control">
			                    </div >
		                	</div>
	                	</div>
	                	<div class="row">
		                    
		                	<div class="col-lg-8">

		                		<div class="form-group">
		                			<label for="exampleInputPassword1">Sizes</label>
		                			<input type="hidden" name="product_id"  id="product_id" value="{{request()->id}}">

		                            		<div class="row p-40">
		                            			@php 
		                            				$retail = $product->ProductSizes->pluck('retail_price','product_type_size_id')->toArray(); 
		                            				 
		                            			@endphp
		                            			@foreach($product_sizes as $key => $size)
	                                                <!-- <div class="custom-control col-lg-1 custom-checkbox mb-2">
						                                <input {{((in_array($size->id,$product->ProductSizes->pluck('product_type_size_id')->toArray())) ? 'checked' : '')}} type="checkbox" class=" size custom-control-input"   value="{{$size->id}}"  name="size[]"   id="autoSizingCheck{{$size->id}}">
						                                <label class="custom-control-label"  for="autoSizingCheck{{$size->id}}">{{$size->name}}</label>
						                            </div> -->
						                            <div class="custom-control col-lg-6 custom-checkbox mb-2 " >
	                                                	<div class="row">
		                                                	<div class="col-lg-2">
								                                <input type="checkbox" {{((in_array($size->id,$product->ProductSizes->pluck('product_type_size_id')->toArray())) ? 'checked' : '')}} class=" size custom-control-input sel_checkbox" value="{{$size->id}}"  name="size[]"   id="autoSizingCheck{{$size->id}}">
								                                <label class="custom-control-label"  for="autoSizingCheck{{$size->id}}">{{$size->name}}</label>
							                            	</div>
							                            	<div class="col-lg-8 all_retail_price {{((in_array($size->id,$product->ProductSizes->pluck('product_type_size_id')->toArray())) ? '' : 'hide')}} ">

							                            		<input type="number" value="{{((in_array($size->id,$product->ProductSizes->pluck('product_type_size_id')->toArray())) ? $retail[$size->id] : '')}}" placeholder="Retail Price" name="size[]" class="form-control  " />
							                            	</div>
						                            	</div>
						                            </div>
					                            @endforeach
					                            <!-- <div class="custom-control col-lg-1 custom-checkbox mb-2 " >
					                                <input type="checkbox" class=" size custom-control-input" {{((SelectedSizeOfProduct($product,'s')== true) ? 'checked' : '')}} value="s"  name="size[]"   id="autoSddfdfizingCheck">
					                                <label class="custom-control-label"  for="autoSddfdfizingCheck">S</label>
					                            </div>
					                            <div class="custom-control col-lg-1 custom-checkbox mb-2 " >
					                                <input type="checkbox" class=" size custom-control-input" {{((SelectedSizeOfProduct($product,'m')== true) ? 'checked' : '')}} value="m"  name="size[]"   id="autoSdfdfdfererizingCheck">
					                                <label class="custom-control-label"  for="autoSdfdfdfererizingCheck">M</label>
					                            </div>
					                            <div class="custom-control col-lg-1 custom-checkbox mb-2 " >
					                                <input type="checkbox" class=" size custom-control-input" value="l"  {{((SelectedSizeOfProduct($product,'l')== true) ? 'checked' : '')}}  name="size[]"   id="autoSiztytytyingCheck">
					                                <label class="custom-control-label"  for="autoSiztytytyingCheck">L</label>
					                            </div> -->
					                           <!--  <div class="custom-control col-lg-1 custom-checkbox mb-2">
					                                <input type="checkbox" class=" size custom-control-input" value="s"  name="size[]"   id="autoSizUYUYingCheck">
					                                <label class="custom-control-label"  or="autoSizUYUYingCheck">S</label>
					                            </div>
					                            <div class="custom-control col-lg-1 custom-checkbox mb-2" >
					                                <input type="checkbox" class=" size custom-control-input" value="m"   name="size[]"   id="autREERERoSizingCheck">
					                                <label class="custom-control-label"  or="autREERERoSizingCheck">M</label>
					                            </div>
					                            <div class="custom-control col-lg-1 custom-checkbox mb-2">
					                                <input type="checkbox" class=" size custom-control-input" value="l"   name="size[]"   id="auto5454545SizingCheck">
					                                <label class="custom-control-label"  or="auto5454545SizingCheck">L</label>
					                            </div> -->
					                            <!-- <div class="custom-control col-lg-1 custom-checkbox mb-2" >
					                                <input type="checkbox" class=" size custom-control-input" {{((SelectedSizeOfProduct($product,'xl')== true) ? 'checked' : '')}} value="xl"  name="size[]"   id="autoSizDDDDingCheck">
					                                <label class="custom-control-label"  for="autoSizDDDDingCheck">XL</label>
					                            </div>
					                            <div class="custom-control col-lg-1 custom-checkbox mb-2">
					                                <input type="checkbox" class=" size custom-control-input" {{((SelectedSizeOfProduct($product,'xxl')== true) ? 'checked' : '')}} value="xxl" name="size[]"   id="aut333oSizingCheck">
					                                <label class="custom-control-label"   for="aut333oSizingCheck">XXL</label>
					                            </div> -->
                                            </div>


		                		</div>
		                	</div>
	                	</div>

	                	<div class="row">
	                		<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Publish Date</label>
			                        {{-- {{dd($product->publish_date)}} --}}
			                        <input type="text" id="publish_date" value="{{($product->publish_date) ? date('Y-m-d',strtotime($product->publish_date)) : ''}}" name="publish_date" class="form-control">
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

			    @foreach($product->productImages as $product_image)
				    <div class="col-md-6 col-xl-3">
				        <div class="card-box product-box">

				            <div class="product-action">
				                <!-- <a href="http://localhost:8000/brands/edit/1" class="btn btn-success btn-xs waves-effect waves-light"><i class="mdi mdi-pencil"></i></a> -->
				                <a href="javascript: void(0);" data-id="{{$product_image->id}}" class="btn btn-danger btn-xs waves-effect waves-light delete_image"><i class="mdi mdi-close"></i></a>
				            </div>

				            <div>
				                <img src="{{asset($product_image->image_url)}}" alt="product-pic" class="img-fluid set_width">
				            </div>
				        </div> <!-- end card-box-->
				    </div>
			    @endforeach





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

		            jQuery("#form_sub").submit();
		            //dzClosure.processQueue();
		        });

		        //send all the form data along with the files:
		        this.on("sendingmultiple", function(data, xhr, formData) {
		        	// return false;
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
     			fd.append("product_id", $('#product_id').val()); 
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
	            fd.append("size", myCheckboxes);
	            $.each(dzClosure.files,function(index,value){
	            	fd.append("files[]", value);
	            });


	             
	            
	            $.ajax({
                url     : "{{route('admin.release_product.update')}}",
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
                    $('.success_msgs').addClass('hide');
                    $('.has-spinner').buttonLoader('stop');
                    
                }
            }
            });
     		})


     		// $("#submit-all").click(function(e){
       //      e.preventDefault(e);
       //      $('.error_msgs_signin').addClass('hide');
       //      
       //  });
	       $('.delete_image').click(function(){
	       	var id = $(this).data('id');
	       	$(this).parent().parent().remove();
	       		$.ajax({
	                url     : "{{route('admin.release_product.delete')}}",
	                method  : 'post',
	                data    : {
	                	'id' : id
	                },
	                success : function(response){
	                    if(response.status == 1){ 
	                    	$('.success_msgs').removeClass('hide');
	                    	$('.error_msgs').addClass('hide'); 
	                        $('.success_msgs').html('<ul><li>'+response.message+'</li></ul>');	                    }
	                    if(response.status == 0){ 
	                    	$('.error_msgs').removeClass('hide');
	                    	$('.success_msgs').addClass('hide'); 
	                        $('.error_msgs').html('<ul><li>'+response.message+'</li></ul>');
	                    }
	                },
	                error: function (reject) {
	                if( reject.status === 422 ) {
	                	 // var errors = $.parseJSON(reject.responseText);
	                  //   var hh = '<ul class="float_left">';
	                  //   $.each(errors.errors, function (key, val) {
	                  //       hh += '<li>' + val + '</li>';
	                  //   });
	                  //   hh += '</ul>';
	                  //   $('.error_msgs').html(hh);
	                  //   $('.error_msgs').removeClass('hide');
	                  //   $('.success_msgs').addClass('hide');
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
     		});
		});	
	</script>
@endsection
