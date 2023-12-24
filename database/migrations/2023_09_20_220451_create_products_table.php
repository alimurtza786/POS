<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
              $table->integer('tsin_id');
            $table->string('image_url');
            $table->integer('offer_id');
            $table->string('sku');
            $table->string('barcode');
            $table->string('product_label_number');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('rrp', 10, 2);
            $table->string('leadtime_days')->nullable();
            $table->json('leadtime_stock')->nullable();
            $table->string('status');
            $table->string('title');
            $table->string('offer_url');
            $table->json('stock_at_takealot');
            $table->json('stock_on_way');
            $table->integer('total_stock_on_way');
            $table->json('stock_cover');
            $table->integer('total_stock_cover');
            $table->json('sales_units');
            $table->integer('stock_at_takealot_total');
            $table->timestamp('date_created');
            $table->string('storage_fee_eligible')->nullable();
            $table->string('discount');
            $table->boolean('discount_shown');
            $table->boolean('replen_block_jhb');
            $table->boolean('replen_block_cpt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
