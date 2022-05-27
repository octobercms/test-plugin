<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest1Tables People
 */
class CreateTest1Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_people', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('preferred_name')->nullable();
            $table->string('bio')->nullable();
            $table->string('expenses')->nullable();
            $table->datetime('birth')->nullable();
            $table->time('birthtime')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('favcolor')->nullable();
            $table->text('hobbies')->nullable();
            $table->text('sports')->nullable();
            $table->boolean('is_married')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_phones', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('brand')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('person_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_people');
        Schema::dropIfExists('october_test_phones');
    }
}
