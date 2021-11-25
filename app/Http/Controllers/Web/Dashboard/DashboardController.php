<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 21-Oct-19
 * Time: 5:34 PM
 */

namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('web.dashboard.buying.listing.index');
    }
}