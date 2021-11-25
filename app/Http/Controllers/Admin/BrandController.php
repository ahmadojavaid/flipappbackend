<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Brand;
use Storage;

class BrandController extends Controller
{
    public function index(){
    	$brands = Brand::orderBy('created_at','desc')->paginate(10);
    	return view('admin.brands.index',compact('brands'));
    }
    public function create(){
    	return view('admin.brands.add-brand');
    }
    public function save(Request $request){
    	$this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',	
        ]);

        $brand = new Brand();
        $brand->brand_name = request()->title;
        $brand->description = request()->description;
        if(request()->file('image')){
        	$file = request()->file("image");
			$file_unique_name = 'brand' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
    		$file->move(base_path('public/uploads/brandImages/'), $file_unique_name);
    		$brand->brand_image = 'uploads/brandImages/'.$file_unique_name;
        }
        $is_saved = $brand->save();
        if($is_saved){
        	flash('Success, Record Saved Successfully.')->success();
        	return redirect()->route('admin.brand.index');
        }
    }
    public function edit($id){
    	$brand = Brand::find($id);
    	if($brand){
    		return view('admin.brands.edit-brand',compact('brand'));
    	}
    }
    public function update(Request $request){
    	$this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        if(request()->img_del == 1){
        	$this->validate($request, [
            	'image' => 'required',	
        	]);
        }
        $brand = Brand::find(request()->id);
        $brand->brand_name = request()->title;
        $brand->description = request()->description;
        if((request()->img_del == 1) || request()->file("image")){
        	// unlink(base_path('public\\'.$brand->brand_image));
        	$file = request()->file("image");
			$file_unique_name = 'brand' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
    		$file->move(base_path('public/uploads/brandImages/'), $file_unique_name);
    		$brand->brand_image = 'uploads/brandImages/'.$file_unique_name;
        }
        $is_updated = $brand->save();
        if($is_updated){
        	flash('Success, Record Updated Successfully.')->success();
        	return redirect()->route('admin.brand.index');
        }
    }
}


 