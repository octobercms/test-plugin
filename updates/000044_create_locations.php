<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->text('available_services')->nullable();
            $table->boolean('is_enabled')->nullable();
            $table->integer('sort_order')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_locations');
    }
};
