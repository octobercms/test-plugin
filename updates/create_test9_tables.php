<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest9Tables Pages
 */
class CreateTest9Tables extends Migration
{
    public function up()
    {
        Db::transaction(function() {
            Schema::create('october_test_pages', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('type')->unsigned()->nullable();
                $table->text('content')->nullable();
                $table->integer('layout_id')->nullable()->unsigned();
            });

            Schema::create('october_test_layouts', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('type')->unsigned()->nullable();
                $table->text('content')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_pages');
        Schema::dropIfExists('october_test_layouts');
    }
}
