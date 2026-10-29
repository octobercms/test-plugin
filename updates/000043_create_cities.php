<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_cities', function (Blueprint $table) {
            $table->id();
            // Testing a custom foreign key name, see City::$belongsTo country
            $table->unsignedBigInteger('custom_country_id')->nullable()->index();
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_cities');
    }
};
