<?php

namespace October\Test\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateOctoberTestTests extends Migration

{
    public function up()
    {
        Schema::create('october_test_tests', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            /* Grid fields */

            $table->string('grid1')->nullable();
            $table->string('grid2')->nullable();
            $table->string('grid3')->nullable();
            $table->string('grid4')->nullable();
            $table->string('grid5')->nullable();
            $table->string('grid6')->nullable();
            $table->string('grid7')->nullable();
            $table->string('grid8')->nullable();
            $table->string('grid9')->nullable();
            $table->string('grid10')->nullable();
            $table->string('grid11')->nullable();
            $table->string('grid12')->nullable();
            $table->string('grid13')->nullable();
            $table->string('grid14')->nullable();
            $table->string('grid15')->nullable();
            $table->string('grid16')->nullable();
            $table->string('grid17')->nullable();
            $table->string('grid18')->nullable();
            $table->string('grid19')->nullable();
            $table->string('grid20')->nullable();
            $table->text('grid21')->nullable();

            /* New line fields */

            $table->string('newline1')->nullable();
            $table->string('newline2')->nullable();
            $table->string('newline3')->nullable();
            $table->string('newline4')->nullable();
            $table->string('newline5')->nullable();

            /* Grow and stretch fields */

            $table->text('grow1')->nullable();
            $table->text('grow2')->nullable();
            $table->text('grow3')->nullable();
            $table->text('grow4')->nullable();
            $table->text('grow5')->nullable();
            $table->text('grow6')->nullable();
            $table->text('grow7')->nullable();
            $table->text('grow8')->nullable();
            $table->text('stretch1')->nullable();
            $table->text('stretch2')->nullable();
            $table->text('stretch3')->nullable();
            $table->text('stretch4')->nullable();
            $table->text('stretch5')->nullable();
            $table->text('stretch6')->nullable();
            $table->text('stretch7')->nullable();
            $table->text('stretch8')->nullable();

            /* Checkbox and checkbox list fields */

            $table->boolean('check1')->nullable();
            $table->boolean('check2')->nullable();
            $table->boolean('check3')->nullable();
            $table->boolean('check4')->nullable();
            $table->boolean('check5')->nullable();
            
            $table->boolean('checkbox1')->nullable();
            $table->boolean('checkbox2')->nullable();

            /* General table fields */

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();			
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_tests');
    }

}