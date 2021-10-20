<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest10Tables Depends
 */
class CreateTest10Tables extends Migration
{
    public function up()
    {
        Db::transaction(function() {
            Schema::create('october_test_depend', function($table) {
                $table->increments('id')->unsigned();
                $table->string('name')->nullable();
                $table->string('master')->nullable();
                $table->string('slave_text')->nullable();
                $table->text('slave_widget')->nullable();
                $table->text('slave_repiter')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_depend');
    }
}
