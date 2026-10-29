<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->integer('security_code')->nullable();
            $table->string('media_image')->nullable();
            $table->string('media_file')->nullable();
            $table->string('media_folder')->nullable();
            $table->mediumText('media_images')->nullable();
            $table->mediumText('media_files')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_users');
    }
};
