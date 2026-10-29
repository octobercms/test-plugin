<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_tags');
    }
};
