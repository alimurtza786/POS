<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('user_posts', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id');
             $table->string('status');
        $table->integer('offer_id');
         $table->string('offer_url');
          $table->string('image_url');
          $table->timestamp('date_created');
        $table->string('tsin_id');
        $table->string('sku');
        $table->string('title');
        $table->decimal('stock_at_takealot_total', 8, 2);
        $table->decimal('selling_price', 8, 2);
        $table->decimal('rrp', 8, 2);
        $table->string('barcode');
    $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_posts');
    }
}
