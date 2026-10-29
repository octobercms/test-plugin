<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_countries_types', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('attribute_id');
            $table->primary(['country_id', 'attribute_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_countries_types');
    }
};
