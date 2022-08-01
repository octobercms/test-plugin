<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest9Tables Migration
 */
class CreateTest9Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products');
    }
}
