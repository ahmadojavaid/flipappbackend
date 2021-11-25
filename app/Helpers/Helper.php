<?php
use Carbon\Carbon;
use App\Http\Models\ProductSize;
use App\Http\Models\UserPaymentMethodDetail;
 function SelectedSizeOfProduct($product,$size=""){
	foreach($product->productSizes as $key => $value){
		if($value->size == $size){
			return true;exit;
		} 
	}
}

function dateFormat($date){
	return date('d/m/Y', strtotime($date));
}
function dateDiffInDays($date){
	 $now = Carbon::yesterday();
	// dd($datework);
	$a = strtotime($now);
	$b = strtotime($date);
	if(($b > $a)){
		// $date1 = Carbon::parse($datework);
		$date = Carbon::parse($date);
		$diff = $date->diffInDays($now);
		 return $diff;
	 
	}elseif($b == $a){
		return 'today';
	}else{
		return 0;
	}
}
function getRetailPriceBySize($id){
	$product_size = ProductSize::where('id',$id)
									->where('status','active')
									->first();
	if($product_size){
		return $product_size->retail_price;
	}else{
		return 0;
	}
}
function paymentStatus($id,$type){
	$payment = UserPaymentMethodDetail::where('status','active')->where('type',$type)->where('user_id',$id)->count();
	if($payment > 0){
		return true;
	}else{
		return false;
	}
}
function characterLimit($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}
function characterLimitNotDot($x, $length){
	if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length);
    echo $y;
  }
}
function sellerRate($d_rate,$e_rate,$s_rate){
	$total = (int)$d_rate + (int)$e_rate + (int)$s_rate;
	if($total > 0){
		$a = (int)$total / 3;
		return (int)$a;
	}
}

function stringLimit($str){
	return str_limit($str,20);
}