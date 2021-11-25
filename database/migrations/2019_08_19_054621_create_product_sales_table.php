<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * General Info
     * Type of requests for product
     * 1 = bid
     * 2 = ask
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('seller_id');
            $table->Integer('user_id');
            $table->Integer('product_id');
            $table->Integer('product_size_id');
            $table->Integer('sale_price');
            $table->tinyInteger('rating')->default('0');
            $table->string('review')->nullable();
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
        Schema::dropIfExists('product_sales');
    }
}
