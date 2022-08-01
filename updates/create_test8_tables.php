<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest8Tables Pages
 */
class CreateTest8Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_pages', function($table) {
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->integer('type')->unsigned()->nullable();
            $table->text('content')->nullable();
            $table->text('mainimage')->nullable();
            $table->text('image')->nullable();
            $table->boolean('use_layout')->nullable();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('layout_id')->nullable()->unsigned();
        });

        Schema::create('october_test_layouts', function($table) {
            $table->increments('id')->unsigned();
            $table->integer('type')->unsigned()->nullable();
            $table->text('content')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_pages');
        Schema::dropIfExists('october_test_layouts');
    }
}
