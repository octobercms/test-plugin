<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest7Tables Attributes
 */
class CreateTest7Tables extends Migration
{
    public function up()
    {
        Db::transaction(function() {
            Schema::create('october_test_attributes', function($table) {
                $table->increments('id');
                $table->string('type')->nullable();
                $table->string('name')->nullable();
                $table->string('label')->nullable();
                $table->string('code')->nullable();
                $table->boolean('is_default')->default(false);
                $table->integer('sort_order')->nullable();
                $table->timestamps();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_attributes');
    }
}
