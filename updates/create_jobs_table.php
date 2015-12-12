<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateJobsTable extends Migration
{

    public function up()
    {
        Schema::create('october_test_jobs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_jobs');
    }

}
