<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest6Tables Trees
 */
class CreateTest6Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_members', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('parent_name')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_categories', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('october_test_channels', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
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
}
