<?php

use October\Rain\Database\Updates\Migration;

/**
 * Migration for Test 8 (Pages)
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_pages', function($table) {
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->integer('type')->unsigned()->nullable();
            $table->string('status')->nullable();
            $table->text('content')->nullable();
            $table->text('mainimage')->nullable();
            $table->text('image')->nullable();
            $table->text('people')->nullable();
            $table->boolean('use_layout')->nullable();
            $table->text('devices')->nullable();
            $table->string('mobile_size')->nullable();
            $table->string('tablet_size')->nullable();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('layout_id')->nullable()->unsigned();
            $table->integer('pagebanner_id')->nullable()->unsigned();
        });

        Schema::create('october_test_layouts', function($table) {
            $table->increments('id')->unsigned();
            $table->integer('type')->unsigned()->nullable();
            $table->text('content')->nullable();
        });

        Schema::create('october_test_page_banners', function($table) {
            $table->increments('id')->unsigned();
            $table->boolean('is_active')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_pages');
        Schema::dropIfExists('october_test_layouts');
        Schema::dropIfExists('october_test_page_banners');
    }
};
