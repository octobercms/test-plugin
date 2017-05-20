<?php namespace Ocotober\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class VenuesAndFragments extends Migration
{
    public function up()
    {
        Schema::create('october_test_venues', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('october_test_fragments', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('data')->nullable;
            $table->string('attachment_id');
            $table->string('attachment_type');
            $table->string('field');
            $table->integer('sort_order')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('october_test_venues');
        Schema::drop('october_test_fragments');

    }
}