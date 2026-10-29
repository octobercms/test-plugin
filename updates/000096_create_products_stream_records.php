<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_products_stream_records', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            // Testing a belongsToMany Tailor stream record, which uses unsignedInteger to match the increments id of Tailor records
            $table->unsignedInteger('stream_record_id');
            $table->primary(['product_id', 'stream_record_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products_stream_records');
    }
};
