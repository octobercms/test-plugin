<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest4Tables Countries
 */
class CreateTest4Tables extends Migration
{
    public function up()
    {
        Db::transaction(function() {
            Schema::create('october_test_countries', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('code')->nullable();
                $table->text('content')->nullable();
                $table->text('pages')->nullable();
                $table->text('states')->nullable();
                $table->text('locations')->nullable();
                $table->string('language')->nullable();
                $table->string('currency')->nullable();
                $table->boolean('is_active')->nullable();
                $table->timestamps();
            });

            Schema::create('october_test_countries_types', function($table)
            {
                $table->engine = 'InnoDB';
                $table->integer('country_id')->unsigned();
                $table->integer('attribute_id')->unsigned();
                $table->primary(['country_id', 'attribute_id']);
            });

            Schema::create('october_test_cities', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('country_id')->unsigned();
                $table->string('name');
            });

            Schema::create('october_test_locations', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('country_id')->unsigned();
                $table->integer('city_id')->unsigned();
                $table->string('name');
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_countries');
        Schema::dropIfExists('october_test_countries_types');
        Schema::dropIfExists('october_test_cities');
        Schema::dropIfExists('october_test_locations');
    }
}
