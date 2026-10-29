<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_products_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('location_id');
            $table->primary(['product_id', 'location_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products_locations');
    }
};
