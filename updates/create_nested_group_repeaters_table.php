<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateNestedGroupRepeatersTable extends Migration
{
    public function up()
    {
        Schema::create('october_test_nested_group_repeaters', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->json('repeater_data')->nullable();
            $table->json('group_repeater_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_nested_group_repeaters');
    }
}
