<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('october_test_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products');
    }
}
