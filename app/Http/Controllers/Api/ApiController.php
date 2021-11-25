<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\APIHELPER;

class ApiController extends Controller
{
	public $apiHelper;
    public function __construct(){
		$this->apiHelper = new APIHELPER();
	}
}
