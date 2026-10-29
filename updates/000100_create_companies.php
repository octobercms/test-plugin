<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('preset_icon')->nullable();
            $table->string('preset_locales')->nullable();
            $table->string('preset_locales_icons')->nullable();
            // Testing the multisite() schema helper
            $table->multisite();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_companies');
    }
};
