<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grand_parent_id')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('parent_name')->nullable();
            $table->integer('site_id')->nullable()->index();
            $table->unsignedBigInteger('site_root_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_members');
    }
};
