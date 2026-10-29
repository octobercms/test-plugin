<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_galleries_countries', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_id');
            $table->unsignedBigInteger('country_id');
            $table->integer('sort_order')->nullable();
            $table->primary(['gallery_id', 'country_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_galleries_countries');
    }
};
