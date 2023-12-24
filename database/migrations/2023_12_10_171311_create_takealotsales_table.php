<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('user_sales', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id');
        $table->string('order_item_id');
        $table->string('order_id');
        $table->string('order_date');
        $table->string('sale_status');
        $table->string('offer_id');
        $table->string('tsin');
        $table->string('sku');
        $table->string('product_title');
        $table->string('takealot_url_mobi');
        $table->string('selling_price');
        $table->string('quantity');
        $table->string('dc');
        $table->string('customer');
        $table->string('takealot_url');
        $table->string('success_fee');
        $table->string('fulfillment_fee');
        $table->string('courier_collection_fee');
        $table->string('auto_ibt_fee');
        $table->string('total_fee');
        $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_sales');
    }
};
