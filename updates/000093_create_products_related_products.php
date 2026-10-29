<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_products_related_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('related_product_id');
            $table->string('group_name')->nullable();
            $table->primary(['product_id', 'related_product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products_related_products');
    }
};
