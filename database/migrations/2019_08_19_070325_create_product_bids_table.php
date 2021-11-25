<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('user_id');
            $table->Integer('product_id');
            $table->Integer('product_size_id');
            $table->Integer('bid');
            $table->Integer('shipping_price')->nullable();
            $table->Integer('discount_code')->nullable();
            $table->Integer('system_fee')->nullable();
            $table->Integer('paypal_fee')->nullable();
            $table->tinyInteger('bid_status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_bids');
    }
}
