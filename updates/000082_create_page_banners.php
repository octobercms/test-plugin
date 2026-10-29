<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_page_banners', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_page_banners');
    }
};
