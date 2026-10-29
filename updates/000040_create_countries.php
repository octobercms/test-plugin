<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('content')->nullable();
            $table->mediumText('notes')->nullable();
            $table->mediumText('footer')->nullable();
            $table->text('pages')->nullable();
            $table->text('states')->nullable();
            $table->text('locations')->nullable();
            $table->string('language')->nullable();
            $table->string('currency')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_countries');
    }
};
