<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_related_channels', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('related_id');
            $table->primary(['channel_id', 'related_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_related_channels');
    }
};
