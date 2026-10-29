<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('notes')->nullable();
            $table->text('line_items')->nullable();
            $table->text('blocks')->nullable();
            $table->text('block_groups')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_orders');
    }
};
