<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoosTable extends Migration
{
    public function up()
    {
        Schema::create('woos', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('unit');
            $table->decimal('cost', 10, 4);
            $table->decimal('price', 10, 4);
            $table->decimal('alert_quantity', 10, 4);
            $table->string('image')->nullable();
            $table->integer('category_id');
            $table->string('cf1')->nullable();
            $table->string('cf2')->nullable();
            $table->string('cf3')->nullable();
            $table->string('cf4')->nullable();
            $table->string('cf5')->nullable();
            $table->string('cf6')->nullable();
            $table->decimal('quantity', 10, 4);
            $table->integer('tax_rate');
            $table->boolean('track_quantity');
            $table->text('details')->nullable();
            $table->text('warehouse')->nullable();
            $table->string('barcode_symbology');
            $table->text('file')->nullable();
            $table->text('product_details')->nullable();
            $table->integer('tax_method');
            $table->string('type');
            $table->text('supplier1')->nullable();
            $table->decimal('supplier1price', 10, 4);
            $table->text('supplier2')->nullable();
            $table->decimal('supplier2price', 10, 4)->nullable();
            $table->text('supplier3')->nullable();
            $table->decimal('supplier3price', 10, 4)->nullable();
            $table->text('supplier4')->nullable();
            $table->decimal('supplier4price', 10, 4)->nullable();
            $table->text('supplier5')->nullable();
            $table->decimal('supplier5price', 10, 4)->nullable();
            $table->boolean('promotion');
            $table->decimal('promo_price', 10, 4)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('supplier1_part_no')->nullable();
            $table->string('supplier2_part_no')->nullable();
            $table->string('supplier3_part_no')->nullable();
            $table->string('supplier4_part_no')->nullable();
            $table->string('supplier5_part_no')->nullable();
            $table->integer('sale_unit');
            $table->integer('purchase_unit');
            $table->text('brand')->nullable();
            $table->string('slug');
            $table->boolean('featured');
            $table->decimal('weight', 10, 4)->nullable();
            $table->integer('hsn_code');
            $table->integer('views');
            $table->boolean('hide');
            $table->string('second_name')->nullable();
            $table->boolean('hide_pos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('woos');
    }
}
