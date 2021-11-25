<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Http\Models\Product;

class ReleaseProductCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relaese:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the Product Release data if the date is matched then move to Product';

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
        $products = Product::where('product_status',2)->whereDate('publish_date',Carbon::today()->toDateString())->get();
        if($products){
            foreach ($products as $key => $value) {
                $product = Product::where('id',$value->id)->first();
                if($product){
                    $product->product_status = 1;
                    $product->save();
                }
            }    
        }
    }
}
