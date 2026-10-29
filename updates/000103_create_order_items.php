<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2)->nullable();
            $table->boolean('is_price_override')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_order_items');
    }
};
