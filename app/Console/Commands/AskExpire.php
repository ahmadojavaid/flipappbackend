<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\ProductAsk;
use Carbon\Carbon;

class AskExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ask:expire';

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
        $product_asks = ProductAsk::where('ask_status','active')
                                    ->where('expires_at',Carbon::today()->toDateString())
                                    ->get();
        if($product_asks){
            foreach ($product_asks as $key => $value) {
                $productAsk = ProductAsk::where('id',$value->id)->first();
                if($productAsk){
                    $productAsk->ask_status = 'inactive';
                    $productAsk->save();
                }
            }
        }
    }
}
