<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOctoberTestPages extends Migration
{
    public function up()
    {
        Schema::create('october_test_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('type')->unsigned();
            $table->text('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('october_test_pages');
    }
}
