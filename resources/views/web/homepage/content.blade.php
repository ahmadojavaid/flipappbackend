<div class="row">
            <div class="col">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  {{($active == 1) ? 'show active' : ''}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">Just Dropped</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                {{-- <a href="{{route('products')}}" class="text-decoration-none  index-see-all">See All</a> --}}
                            </div>
                        </div>
                         <div class="row pt-2">
                            @if(count($justDroppedProducts) > 0)
                                @foreach($justDroppedProducts as $key => $latest)
                                <div class="p-2 col-sm-12 col-md-3">
                                    {{-- <a href="{{route('single_product',$latest->id)}}" style="color:black"> --}}
                                        <div class="card border-0 shadow">
                                            <img src="{{ ($latest->productImage) ? asset($latest->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
                                            <div class="card-body text-center">

                                                <p class="mb-0 ">{{stringLimit($latest->product_name)}}
                                                </p>
                                                <p class="mb-0 ">
                                                    {{stringLimit($latest->color_way)}}</p>
                                                <div class="d-flex flex-row justify-content-center pt-3 pb-2">
                                                     

                                                </div>
                                            </div>
                                        </div>
                                    {{-- </a> --}}
                                </div>
                                @endforeach
                            @else
                                <pre>
                                    No product found...
                                </pre>
                            @endif
                         
                        </div>

                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">Most Lastest</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="{{route('latest_products')}}" class="text-decoration-none  index-see-all">See All</a>
                            </div>
                        </div>
                        <div class="row pt-2">
                        	@if(count($lastestProducts) > 0)
	                        	@foreach($lastestProducts as $key => $latest)

	                            <div class="p-2 col-sm-12 col-md-3">
                                    <a href="{{route('single_product',$latest->id)}}" style="color:black">
    	                                <div class="card border-0 shadow">
    	                                    <img src="{{ ($latest->productImage) ? asset($latest->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
    	                                    <div class="card-body text-center">

    	                                        <p class="mb-0 ">{{stringLimit($latest->product_name)}}
    	                                        </p>
    	                                        <p class="mb-0 ">{{stringLimit($latest->color_way)}}</p>
                                                <div class="d-flex flex-row justify-content-center pt-3 pb-2">
                                                        
                                                        <div class="p-1">
                                                            <p class="mb-0">LOWEST ASK</p>
                                                        </div>
                                                        <div class="p-1">
                                                            <p class="mb-0 font-weight-bold">{{($latest->singleLowestAsk) ? '£'.$latest->singleLowestAsk->ask : '£0'}}</p>
                                                        </div>
                                                    </div>
                                                {{-- @foreach($latest->lowestAsk as $key => $ask_b)
                                                    @if($key == 2)
                                                        @php break; @endphp
                                                    @endif
        	                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
                                                        <p>Condition <b>{{ ucfirst($ask_b->condition) }}</b></p> 
        	                                            <div class="p-1">
        	                                                <p class="mb-0">LOWEST ASK</p>
        	                                            </div>
        	                                            <div class="p-1">
        	                                                <p class="mb-0 font-weight-bold">{{($ask_b->ask) ? '£'.$ask_b->ask : '£0'}}</p>
        	                                            </div>
        	                                        </div>

                                                @endforeach --}}


                                                


    	                                    </div>
    	                                    <div class="card-footer text-white" style="background-color: black">
    	                                        <div class="d-flex flex-row justify-content-center">
    	                                            <div class="">
    	                                                <p class="mb-0">Sold</p>
    	                                            </div>
    	                                            <div class="">
    	                                                <p class="mb-0 ">253</p>
    	                                            </div>

    	                                        </div>
    	                                    </div>
    	                                </div>
                                    </a>
	                            </div>
	                            @endforeach
	                        @else
	                        	<pre>
	                        		No product found...
	                        	</pre>
	                        @endif
                         
                        </div>

                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">New Lowest Asks</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="{{route('product_lowest_ask_all')}}" class="text-decoration-none  index-see-all">See All</a>
                            </div>
                        </div>
                        <div class="row pt-2">
                        	@if(count($lowestAskProducts) > 0)
	                        	@foreach($lowestAskProducts as $key => $lowest_ask)
		                            <div class="p-2 col-sm-12 col-md-3">
                                        <a href="{{route('single_product',$lowest_ask->id)}}" style="color:black">
    		                                <div class="card border-0 shadow">
    		                                    <img src="{{ ($lowest_ask->productImage) ? asset($lowest_ask->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
    		                                    <div class="card-body text-center">

    		                                        <p class="mb-0 ">{{stringLimit($lowest_ask->product_name)}}
    		                                        </p>
    		                                        <p class="mb-0 ">
    		                                            {{stringLimit($lowest_ask->color_way)}}</p>
                                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2"> 
                                                            <div class="p-1">
                                                                <p class="mb-0">LOWEST ASK</p>
                                                            </div>
                                                            <div class="p-1">
                                                                <p class="mb-0 font-weight-bold">{{($lowest_ask->singleLowestAsk) ? '£'.$lowest_ask->singleLowestAsk->ask : '£ 0'}}</p>
                                                            </div>
                                                        </div>
    		                                        {{-- @foreach($lowest_ask->lowestAsk as $key => $ask_b)
                                                        @if($key == 2)
                                                            @php break; @endphp
                                                        @endif
                                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
                                                            <p>Condition <b>{{ ucfirst($ask_b->condition) }}</b></p> 
                                                            <div class="p-1">
                                                                <p class="mb-0">LOWEST ASK</p>
                                                            </div>
                                                            <div class="p-1">
                                                                <p class="mb-0 font-weight-bold">{{($ask_b->ask) ? '£'.$ask_b->ask : '£0'}}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach --}}
    		                                    </div>
    		                                    <div class="card-footer border-0 text-right" style="background-color: white">
    		                                        <p class="mb-0 text-black-50">
                                                        {{($lowest_ask->singleLowestAsk) ? @$lowest_ask->singleLowestAsk->created_at->diffForHumans() : ''}}
                                                    </p>
    		                                    </div>
    		                                </div>
                                        </a>
		                            </div>
	                            @endforeach
                            @else
                            	<pre>NO Lowest Ask Found...</pre>
                            @endif
                           
                        </div>

                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">New Highest Bids</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="{{route('product_highest_bid_all')}}" class="text-decoration-none  index-see-all">See All</a>
                            </div>
                        </div>
                        <div class="row pt-2">
                        	
                        	@if(count($highestBidProducts) > 0)
	                        	@foreach($highestBidProducts as $key => $highest_ask)

		                            <div class="p-2 col-sm-12 col-md-3">
                                        <a href="{{route('single_product',$highest_ask->id)}}" style="color:black">
    		                                <div class="card border-0 shadow">
    		                                    <img src="{{ ($highest_ask->productImage) ? asset($highest_ask->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
    		                                    <div class="card-body text-center">

    		                                        <p class="mb-0 ">{{stringLimit($highest_ask->product_name)}}
    		                                        </p>
    		                                        <p class="mb-0 ">
    		                                             {{stringLimit($highest_ask->color_way)}}</p>
    		                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
    		                                            <div class="p-1">
    		                                                <p class="mb-0">HIGHEST BID</p>
    		                                            </div>
    		                                            <div class="p-1">
    		                                                <p class="mb-0 font-weight-bold">{{($highest_ask->singleHighestBid) ? '£'.$highest_ask->singleHighestBid->bid : '£0'}}</p>
    		                                            </div>

    		                                        </div>
    		                                    </div>
    		                                    <div class="card-footer border-0 text-right" style="background-color: white">
                                                    <p class="mb-0 text-black-50">{{@$highest_ask->created_at->diffForHumans()}}</p>
    		                                        {{-- <p class="mb-0 text-black-50">{{@$highest_ask->singleHighestBid->created_at->diffForHumans()}}</p> --}}
    		                                    </div>
    		                                </div>
                                        </a>
		                            </div>
	                            @endforeach
                            @endif
                            
                        </div>
                        <div class="row index-released-calendar ">
                            <div class=" p-2 col-sm-12 col-md-12 ">
                                <section class="p-2 text-center text-white" style="background-color: black">
                                    <h2>Release Calendar</h2>
                                </section>

                            </div>
                        </div>

                        <div class="row" style="padding-bottom: 8rem;">
                        	@if(count($calenderProducts) > 0)
                        	@foreach($calenderProducts as $calender_product)
	                            <div class="p-2 col-sm-12 col-md-3">
	                                <div class="card border-0 shadow">
	                                    <div class="card-header border-0 bg-white">
	                                        <div class="d-flex flex-row justify-content-between">
	                                            <div class="p-1">
	                                                <p class="mb-0 d-inline">{{$calender_product->publish_date->format('M')}}</p>
	                                                <p class="mb-0 d-inline">|</p>
	                                                <p class="mb-0 d-inline">{{$calender_product->publish_date->format('d')}}</p>
	                                            </div>
	                                            <div class="p-1">
	                                                <a href="javascript:void(0);" class="text-decoration-none" style="color: black;"><i class="fas fa-plus"></i></a>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <img src="{{ ($calender_product->productImage) ? asset($calender_product->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
	                                    <div class="card-body text-center">


	                                        <p class="mb-0 ">{{stringLimit($calender_product->product_name)}}
	                                        </p>
	                                        <p class="mb-0 ">
	                                            {{stringLimit($calender_product->color_way)}}</p>
	                                        <!-- <div class="d-flex flex-row justify-content-center pt-3 pb-2">
	                                            <div class="p-1">
	                                                <p class="mb-0">LOWEST ASK</p>
	                                            </div>
	                                            <div class="p-1">
	                                                <p class="mb-0 font-weight-bold"></p>
	                                            </div>

	                                        </div>
	                                        <button class="btn  text-white index-bid-btn rounded-0" style="padding: 2px;">
	                                            BID
	                                        </button> -->
	                                    </div>
	                                </div>
	                            </div>
                            @endforeach
                            @endif
                            
                        </div>
                    </div>
                    





                    <div class="tab-pane fade {{($active == 2) ? 'show active' : ''}}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row pt-2">
                        	@if(count($lastestProducts) > 0)
	                        	@foreach($lastestProducts as $key => $latest)

	                            <div class="p-2 col-sm-12 col-md-3">
                                    <a href="{{route('single_product',$latest->id)}}" style="color:black">
    	                                <div class="card border-0 shadow">
    	                                    <img src="{{ ($latest->productImage) ? asset($latest->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
    	                                    <div class="card-body text-center">

    	                                        <p class="mb-0 ">{{stringLimit($latest->product_name)}}
    	                                        </p>
    	                                        <p class="mb-0 ">
    	                                            {{stringLimit($latest->color_way)}}</p>
    	                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
    	                                            <div class="p-1">
    	                                                <p class="mb-0">LOWEST ASK</p>
    	                                            </div>
    	                                            <div class="p-1">
    	                                                <p class="mb-0 font-weight-bold">{{($latest->singleLowestAsk) ? '£'.$latest->singleLowestAsk->ask : '£0'}}</p>
    	                                            </div>

    	                                        </div>
    	                                    </div>
    	                                    <div class="card-footer text-white" style="background-color: black">
    	                                        <div class="d-flex flex-row justify-content-center">
    	                                            <div class="">
    	                                                <p class="mb-0">Sold</p>
    	                                            </div>
    	                                            <div class="">
    	                                                <p class="mb-0 ">253</p>
    	                                            </div>

    	                                        </div>
    	                                    </div>
    	                                </div>
                                    </a>
	                            </div>
	                            @endforeach
                                
	                        @else
	                        	<pre>
	                        		No popular product found...
	                        	</pre>
	                        @endif
                         
                        </div>
                        @if($paginate_page == 1)
                            <div class="row"> 
                                {{$lastestProducts->render()}}
                            </div>
                        @endif
                    </div>






                    <div class="tab-pane fade {{($active == 3) ? 'show active' : ''}}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">Lastest Brands</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="{{route('brands')}}"class="text-decoration-none  index-see-all">See All</a>
                            </div>
                        </div>
                        <div class="row">
                        	
                        </div>

                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">Most Popular</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="/#" class="text-decoration-none  index-see-all">See All</a>
                            </div>
                        </div>
                        <div class="row pt-2">
                        	@if(count($lastestProducts) > 0)
	                        	@foreach($lastestProducts as $key => $latest)

	                            <div class="p-2 col-sm-12 col-md-3">
	                                <div class="card border-0 shadow">
	                                    <img src="{{ ($latest->productImage) ? asset($latest->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
	                                    <div class="card-body text-center">

	                                        <p class="mb-0 ">{{stringLimit($latest->product_name)}}
	                                        </p>
	                                        <p class="mb-0 ">
	                                            {{stringLimit($latest->color_way)}}</p>
	                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
	                                            <div class="p-1">
	                                                <p class="mb-0">LOWEST ASK</p>
	                                            </div>
	                                            <div class="p-1">
	                                                <p class="mb-0 font-weight-bold">{{($latest->singleLowestAsk) ? '£'.$latest->singleLowestAsk->ask : '£0'}}</p>
	                                            </div>

	                                        </div>
	                                    </div>
	                                    <div class="card-footer text-white" style="background-color: black">
	                                        <div class="d-flex flex-row justify-content-center">
	                                            <div class="">
	                                                <p class="mb-0">Sold</p>
	                                            </div>
	                                            <div class="">
	                                                <p class="mb-0 ">253</p>
	                                            </div>

	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                            @endforeach
	                        @else
	                        	<pre >
	                        		No popular product found...
	                        	</pre>
	                        @endif
                         
                        </div>



                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">New Lowest Asks</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="{{route('product_lowest_ask_all')}}" class="text-decoration-none  index-see-all">See All</a>
                             </div>
                        </div>
                        <div class="row pt-2">
                        	@if(count($lowestAskProducts) > 0)
	                        	@foreach($lowestAskProducts as $key => $lowest_ask)
		                            <div class="p-2 col-sm-12 col-md-3">
                                        <a href="{{route('single_product',$lowest_ask->id)}}" style="color:black"> 
    		                                <div class="card border-0 shadow">
    		                                    <img src="{{ ($lowest_ask->productImage) ? asset($lowest_ask->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
    		                                    <div class="card-body text-center">

    		                                        <p class="mb-0 ">{{stringLimit($lowest_ask->product_name)}}
    		                                        </p>
    		                                        <p class="mb-0 ">
    		                                            {{stringLimit($lowest_ask->color_way)}}</p>
    		                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
    		                                            <div class="p-1">
    		                                                <p class="mb-0">LOWEST ASK</p>
    		                                            </div>
    		                                            <div class="p-1">
    		                                                <p class="mb-0 font-weight-bold">{{($lowest_ask->singleLowestAsk) ? '£'.$lowest_ask->singleLowestAsk->ask : '£0'}}</p>
    		                                            </div>

    		                                        </div>
    		                                    </div>
    		                                    <div class="card-footer border-0 text-right" style="background-color: white">
    		                                        <p class="mb-0 text-black-50">{{@$lowest_ask->created_at->diffForHumans()}}</p>
    		                                    </div>
    		                                </div>
                                        </a>
		                            </div>
	                            @endforeach
                            @else
                            	<pre>
                                    NO Lowest Ask Found...
                                </pre>
                            @endif
                           
                        </div>

                        <div class="row text-center index-heading-line">
                            <div class="col ">

                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-red">
                            </div>
                            <div class="col-sm-3 ">
                                <p class="mb-0 font-weight-bold " style="font-size: 23px;">New Highest Bids</p>
                            </div>
                            <div class="col-sm-2 p-0">
                                <hr class="index-hr-black">
                            </div>
                            <div class="col ">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <a href="{{route('product_highest_bid_all')}}" class="text-decoration-none  index-see-all">See All</a>
                             </div>
                        </div>
                        <div class="row pt-2">
                        	
                        	@if(count($highestBidProducts) > 0)
	                        	@foreach($highestBidProducts as $key => $highest_ask)

		                            <div class="p-2 col-sm-12 col-md-3">
                                        <a href="{{route('single_product',$highest_ask->id)}}" style="color:black"> 
    		                                <div class="card border-0 shadow">
    		                                    <img src="{{ ($highest_ask->productImage) ? asset($highest_ask->productImage->image_url) : '' }}" class="home_page_img card-img-top index-card-img home_page_img" alt="...">
    		                                    <div class="card-body text-center">

    		                                        <p class="mb-0 ">{{stringLimit($highest_ask->product_name)}}
    		                                        </p>
    		                                        <p class="mb-0 ">
    		                                             {{stringLimit($highest_ask->color_way)}}</p>
    		                                        <div class="d-flex flex-row justify-content-center pt-3 pb-2">
    		                                            <div class="p-1">
    		                                                <p class="mb-0">HIGHEST BID</p>
    		                                            </div>
    		                                            <div class="p-1">
    		                                                <p class="mb-0 font-weight-bold">{{($highest_ask->singleHighestBid) ? '£'.$highest_ask->singleHighestBid->bid : '£0'}}</p>
    		                                            </div>

    		                                        </div>
    		                                    </div>
    		                                    <div class="card-footer border-0 text-right" style="background-color: white">
    		                                        <p class="mb-0 text-black-50">{{@$highest_ask->singleHighestBid->created_at->diffForHumans()}}</p>
    		                                    </div>
    		                                </div>
                                        </a>
		                            </div>
	                            @endforeach
                            @endif
                            
                        </div>
                        <div class="row index-released-calendar ">
                            <div class=" p-2 col-sm-12 col-md-12 ">
                                <section class="p-2 text-center text-white" style="background-color: black">
                                    <h2>Release Calendar</h2>
                                </section>

                            </div>
                        </div>

                        <div class="row" style="padding-bottom: 8rem;">
                        	@if(count($calenderProducts) > 0)
                        	@foreach($calenderProducts as $calender_product)
	                            <div class="p-2 col-sm-12 col-md-3">
	                                <div class="card border-0 shadow">
	                                    <div class="card-header border-0 bg-white">
	                                        <div class="d-flex flex-row justify-content-between">
	                                            <div class="p-1">
	                                                <p class="mb-0 d-inline">{{$calender_product->publish_date->format('M')}}</p>
	                                                <p class="mb-0 d-inline">|</p>
	                                                <p class="mb-0 d-inline">{{$calender_product->publish_date->format('d')}}</p>
	                                            </div>
	                                            <div class="p-1">
	                                                <a href="/#" class="text-decoration-none" style="color: black;"><i class="fas fa-plus"></i></a>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <img src="{{ ($calender_product->productImage) ? asset($calender_product->productImage->image_url) : '' }}" class="card-img-top index-card-img home_page_img" alt="...">
	                                    <div class="card-body text-center">


	                                        <p class="mb-0 ">{{stringLimit($calender_product->product_name)}}
	                                        </p>
	                                        <p class="mb-0 ">
	                                            {{$calender_product->color_way}}</p>
	                                        <!-- <div class="d-flex flex-row justify-content-center pt-3 pb-2">
	                                            <div class="p-1">
	                                                <p class="mb-0">LOWEST ASK</p>
	                                            </div>
	                                            <div class="p-1">
	                                                <p class="mb-0 font-weight-bold"></p>
	                                            </div>

	                                        </div>
	                                        <button class="btn  text-white index-bid-btn rounded-0" style="padding: 2px;">
	                                            BID
	                                        </button> -->
	                                    </div>
	                                </div>
	                            </div>
                            @endforeach
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>