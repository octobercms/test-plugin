<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Migration for Attributes
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_attributes', function($table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('label')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_repeater_items', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->mediumText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_attributes');
        Schema::dropIfExists('october_test_repeater_items');
    }
};

