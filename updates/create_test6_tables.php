<?php

use October\Rain\Database\Updates\Migration;

/**
 * Migration for Test 6 (Trees)
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_members', function($table) {
            $table->increments('id');
            $table->integer('grand_parent_id')->unsigned()->index()->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('parent_name')->nullable();
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('site_root_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('october_test_categories', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('site_root_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('october_test_channels', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('services')->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('october_test_related_channels', function($table) {
            $table->integer('channel_id')->unsigned();
            $table->integer('related_id')->unsigned();
            $table->primary(['channel_id', 'related_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_members');
        Schema::dropIfExists('october_test_categories');
        Schema::dropIfExists('october_test_channels');
        Schema::dropIfExists('october_test_related_channels');
    }
};
