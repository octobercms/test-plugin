<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateNotesTable extends Migration
{

    public function up()
    {
        Schema::create('october_test_notes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->unsignedInteger('person_id')->index();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('october_test_people')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_notes');
    }

}
