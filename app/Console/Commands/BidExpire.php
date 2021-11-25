<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\ProductBid;
use Carbon\Carbon;


class BidExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bid:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $product_bids = ProductBid::where('bid_status','active')
                                    ->where('expires_at',Carbon::today()->toDateString())
                                    ->get();
        if($product_bids){
            foreach ($product_bids as $key => $value) {
                $productBid = ProductBid::where('id',$value->id)->first();
                if($productBid){
                    $productBid->bid_status = 'inactive';
                    $productBid->save();
                }
            }
        }
    }
}
