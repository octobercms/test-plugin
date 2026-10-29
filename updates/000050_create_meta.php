<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_meta', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('taggable');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('robot_index')->nullable();
            $table->string('robot_follow')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_meta');
    }
};
