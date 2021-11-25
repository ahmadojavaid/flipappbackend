<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAsksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_asks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('seller_id');
            $table->Integer('product_id');
            $table->Integer('product_size_id');
            $table->Integer('ask');
            $table->Integer('shipping_price')->nullable();
            $table->Integer('system_fee')->nullable();
            $table->Integer('paypal_fee')->nullable();
            $table->date('expires_at');
            $table->tinyInteger('ask_status')->default('0');
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
        Schema::dropIfExists('product_asks');
    }
}
