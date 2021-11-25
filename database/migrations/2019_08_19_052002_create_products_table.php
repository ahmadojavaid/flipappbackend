<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('brand_id');
            $table->string('product_name');
            $table->tinyInteger('condition')->nullable();
            $table->string('style')->nullable();
            $table->string('color_way')->nullable();
            $table->Integer('retail_price')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('bid_end_date')->nullable();
            $table->dateTime('ask_end_date')->nullable();
            $table->tinyInteger('is_supreme')->default('0');
            $table->tinyInteger('product_status')->nullable();
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
        Schema::dropIfExists('products');
    }
}
