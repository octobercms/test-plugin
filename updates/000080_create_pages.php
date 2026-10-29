<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedInteger('type')->nullable();
            $table->string('status')->nullable();
            $table->text('content')->nullable();
            $table->text('mainimage')->nullable();
            $table->text('image')->nullable();
            $table->text('people')->nullable();
            $table->boolean('use_layout')->nullable();
            $table->text('devices')->nullable();
            $table->string('mobile_size')->nullable();
            $table->string('tablet_size')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('layout_id')->nullable()->index();
            $table->unsignedBigInteger('pagebanner_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_pages');
    }
};
