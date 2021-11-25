<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DataTables;
use App\Http\Models\Product; 
use App\Http\Models\ProductSize;
use App\Http\Models\ProductType;
use App\Http\Models\ProductTypeSize;
use App\Http\Models\ProductImage;
use App\Http\Models\Brand;

class ReleaseProductController extends Controller
{
    public function index(){
    	return view('admin.release.products.index');
    }
    public function getProducts(){
    	$now = Carbon::now();
    	$products 	= Product::with('brandName','ProductSizes.productTypeSize')->where('product_status', 2)->orderBy('created_at','desc')->get();
        // dd($products);
		return DataTables::of($products)
			->editColumn('product_sizes.size',function($product){
				if($product){

					$sizes = '';
					if($product->ProductSizes){
						foreach ($product->ProductSizes as $key => $value) {

							// switch ($value->size) {
							//     case "xs":
							//         $sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">Extra Small</div>';
							//         break;
							//     case "s":
							//         $sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">Small</div>';
							//         break;
							//     case "m":
							//         $sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">Medium</div>';
							//         break;
							//     case "l":
							//         $sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">Large</div>';
							//         break;
							//     case "xl":
							//         $sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">Extra Large</div>';
							//         break;
							//     case "xxl":
							//         $sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">Extra Extra Large(xxl)</div>';
							//         break;
							// }
							$sizes .= '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">'.$value->productTypeSize->name.'</div>';
						}						
					}
					return $sizes;
				}
			})
			->editColumn('publish_date',function($product){
				if($product){
					if(!empty($product->publish_date)){
						return date('Y-m-d',strtotime($product->publish_date));
					}
				}
				
			})

			->rawColumns(['status', 'action', 'product_sizes.size'])
			->addColumn('action',function($product){
				return view('admin.release.products.action-button',compact('product'))->render();
			})->make(true);
    }
    public function create(){
    	$brands = Brand::all();
        $product_type = ProductType::where('name','clothing')->with('productTypeSize')->first();
      //  dd($product_type->name);
    	return view('admin.release.products.add-product',compact('brands','product_type'));
    }
      public function store(Request $request){
    	 // dd(request()->all());
    	 $this->validate($request, [
            'brand_name' => 'required',
            'product_name' => 'required',
            // 'condition' => 'required',
            'style' => 'required',
            'color_way' => 'required', 
            'size' => 'required ', 
            'files' => 'required|max:5',
            'publish_date' => 'required'

        ]);
        $sizes = explode(',',request()->size);
        foreach ($sizes as $key => $value) {
            if (strpos($value, '_') !== false) {
                    $ke = explode('_', $value);
                    $v_id = $ke[0];
                    $retail_price = $ke[1];

                    if(empty($retail_price)){
                        $this->validate($request, [
                            'retail_price' => 'required',
                        ]);
                    }
                }
            
         }
    	$product = new Product();
    	$product->product_name = request()->product_name;
    	// $product->condition = request()->condition;
    	$product->style = request()->style;
    	$product->color_way = request()->color_way;
    	$product->product_status = 2;
    	$product->brand_id = request()->brand_name;
    	$product->publish_date = request()->publish_date;
    	$is_saved = $product->save();
    	if($is_saved){
    		$sizes = explode(',',request()->size);
    		foreach ($sizes as $key => $value) {
    			 
                if (strpos($value, '_') !== false) {
                    $ke = explode('_', $value);
                    $v_id = $ke[0];
                    $retail_price = $ke[1];
                }else{
                    $v_id = $value;
                    $retail_price = '';
                }
                $product_size = new ProductSize();
    			$product_size->product_id = $product->id;
                $product_size->product_type_size_id = $v_id;
    			$product_size->retail_price = $retail_price;

    			$size_saved = $product_size->save();
    			if($size_saved){}else{
    				$arr = [ 
                        'message' => 'Product Size Not Saved, Something went wrong',
                        'status' => 0
                    ];
            		return response()->json($arr);
    			}
    		}
    		$d = request()->files;
    		// dd($d);
    		foreach ($d as $key => $filee) {
                // dd($filee);
    			 foreach ($filee as $key => $file) {
    			 	$product_image = new ProductImage();
					$file_unique_name = 'product' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
		    		$file->move(base_path('public/uploads/productImages/'), $file_unique_name);
		    		$product_image->product_id = $product->id;
		    		$product_image->image_url = 'uploads/productImages/'.$file_unique_name;
		    		$img_saved = $product_image->save();
		    		if($img_saved){}else{
		    			$arr = [ 
	                        'message' => 'Product Image Not Saved, Something went wrong',
	                        'status' => 0
	                    ];
	            		return response()->json($arr);
		    		}
    			 }
    			
    		}
    		$arr = [ 
	                'url' => route('admin.release_product.index'),
	                'status' => 1,
	                'message' => 'Success!, Record Saved Successfully.'
	            ];
	    	return response()->json($arr);
    	}else{
    		$arr = [ 
                        'message' => 'Some thing went Wrong',
                        'status' => 0
                    ];
            return response()->json($arr);
    	}
    	

    }

    public function edit($id){
        $brands = Brand::all();
        $product_sizes = ProductTypeSize::all();
        $product = Product::where('id',$id)->with('ProductSizes')->first();
        // echo $product->ProductSizes->pluck('id')->toArray();
        $product_type = ProductType::with('productTypeSize')->get();
        if($product){
            return view('admin.release.products.edit',compact('brands','product','product_type','product_sizes'));
        }
    }

    public function update(Request $request){
         // dd(request()->all());
        $this->validate($request, [
            'brand_name' => 'required',
            'product_name' => 'required',
            // 'condition' => 'required',
            'style' => 'required',
            'color_way' => 'required', 
            'size' => 'required ',
            'publish_date' => 'required' 
            //'files' => 'required ',
        ]);
        $sizes = explode(',',request()->size);
        foreach ($sizes as $key => $value) {
            if (strpos($value, '_') !== false) {
                    $ke = explode('_', $value);
                    $v_id = $ke[0];
                    $retail_price = $ke[1];

                    if(empty($retail_price)){
                        $this->validate($request, [
                            'retail_price' => 'required',
                        ]);
                    }
                }
            
         }
         unset($sizes);
        $id = request()->product_id;
        $product = Product::where('id',$id)->first();
        if($product){
             // dd($product->productImages->count());
            if($product->productImages->count() > 0){
                //  $this->validate($request, [
                //     'files' => 'size:1024',
                // ]);
                 $i = 0;
                    foreach (request()->files as $key => $value) {
                        $i = $i+1;
                    }
                    $a = (int)$i + (int)$product->productImages->count();
                    if($a > 5){
                       $this->validate($request, [
                        'files' => 'max:0 ',
                        ]);  
                    }
            }else{
                 
                $this->validate($request, [
                    'files' => 'required',
                ]);
            }
            $product->product_name = request()->product_name;
            // $product->condition = request()->condition;
            $product->style = request()->style;
            $product->color_way = request()->color_way;
            $product->product_status = 2;
            $product->brand_id = request()->brand_name;
            $product->publish_date = request()->publish_date;
            $is_saved = $product->save();
            if($is_saved){
               // $be_product_sizes = $product->ProductSizes->pluck('product_type_size_id');
               // dd($be_product_sizes);
                $be_product_sizes = ProductSize::where('product_id',$product->id)->get()->pluck('product_type_size_id');
                $be_product_sizes = $be_product_sizes->toArray();    
                $sizes = explode(',',request()->size);
                foreach ($sizes as $key => $value) {

                        if (strpos($value, '_') !== false) {
                            $ke = explode('_', $value);
                            $v_id = $ke[0];
                            $retail_price = $ke[1];

                            if(empty($retail_price)){
                                $this->validate($request, [
                                    'retail_price' => 'required',
                                ]);
                            }
                        }


                    if(in_array($v_id, $be_product_sizes)){

                        $product_size_check = ProductSize::where('product_type_size_id',$v_id)->where('product_id',$product->id)->first();
                        $product_size_check->status = 'active';
                        $product_size_check->retail_price = $retail_price;
                        $product_size_check->save();
                        $pos = array_search($value, $be_product_sizes);
                        unset($be_product_sizes[$pos]);
                    }else{
                        $product_size = new ProductSize();
                        $product_size->product_id = $product->id;
                        $product_size->product_type_size_id = $v_id;
                        $product_size->retail_price = $retail_price;
                        $size_saved = $product_size->save();
                        if($size_saved){}else{
                            $arr = [ 
                                'message' => 'Product Size Not Saved, Something went wrong',
                                'status' => 0
                            ];
                          }
                      }
                    //$product_size_check = ProductSize::where('size',$value)->where('product_id',$product->id)->first();
                    // $count = ProductSize::count();
                    // $ids = ProductSize::pluck('id');

                    // if($product_size_check){
                    //     $product_size_check->size = $value;
                    //     $product_size_check->save();
                    // }else{
                    //     $product_size = new ProductSize();
                    //     $product_size->product_id = $product->id;
                    //     $product_size->size = $value;
                    //     $size_saved = $product_size->save();
                    //     if($size_saved){}else{
                    //         $arr = [ 
                    //             'message' => 'Product Size Not Saved, Something went wrong',
                    //             'status' => 0
                    //         ];
                    //         return response()->json($arr);
                    //     }
                    // }
                }
                if(count($be_product_sizes) > 0){
                $checkProductSize = ProductSize::whereIn('product_type_size_id',$be_product_sizes)->where('product_id',$product->id)->update(['status' => 'inactive']);
                }//dd($be_product_sizes);
                if(request()->files){

                    $d = request()->files;
                    // dd($d);
                    foreach ($d as $key => $filee) {
                        // dd($filee);
                         foreach ($filee as $key => $file) {
                            $product_image = new ProductImage();
                            $file_unique_name = 'product' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
                            $file->move(base_path('public/uploads/productImages/'), $file_unique_name);
                            $product_image->product_id = $product->id;
                            $product_image->image_url = 'uploads/productImages/'.$file_unique_name;
                            $img_saved = $product_image->save();
                            if($img_saved){}else{
                                $arr = [ 
                                    'message' => 'Product Image Not Saved, Something went wrong',
                                    'status' => 0
                                ];
                                return response()->json($arr);
                            }
                         }
                        
                    }
                    $arr = [ 
                            'url' => route('admin.release_product.index'),
                            'status' => 1,
                            'message' => 'Success!, Record Saved Successfully.'
                        ];
                    return response()->json($arr);
                }




            }
        }else{
            $arr = [ 
                        'message' => 'Some thing went Wrong',
                        'status' => 0
                    ];
            return response()->json($arr);
        }
    }
     public function delete() {
        $id  = request()->id;
        if(!empty($id)){
            $product = ProductImage::where('id',$id)->first();
            if($product){
                $product->delete();
                $arr = [ 
                    //'url' => route('admin.product.index'),
                    'status' => 1,
                    'message' => 'Success!, Image Deleted Successfully.'
                ];
                return response()->json($arr);
            }
        }else{
            $arr = [ 
                        'message' => 'Some thing went Wrong',
                        'status' => 0
                    ];
            return response()->json($arr);
        }
    }
}
