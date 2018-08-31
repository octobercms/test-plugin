<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('october_test_pages', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');            
            $table->integer('content_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('nest_left');
            $table->integer('nest_right');
            $table->integer('nest_depth')->default(0);
            $table->timestamps();
        });

        Schema::create('october_test_contents', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('page_id')->nullable();
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_contents');
        Schema::dropIfExists('october_test_pages');
    }
}
