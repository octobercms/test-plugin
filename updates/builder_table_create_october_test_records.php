<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOctoberTestRecords extends Migration
{
    public function up()
    {
        Schema::create('october_test_records', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('fields_in_json');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('october_test_records');
    }
}
