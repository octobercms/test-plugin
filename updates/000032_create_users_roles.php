<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_users_roles', function (Blueprint $table) {
            // Testing a pivot model with its own incrementing id, see UserRolePivot
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->string('clearance_level')->nullable();
            $table->boolean('is_executive')->default(false);
            // Testing a nullable column with a default, which the Nullable trait on UserRolePivot saves as null when its dropdown is left empty
            $table->unsignedSmallInteger('evolution')->nullable()->default(0);
            $table->unsignedInteger('salary')->nullable()->default(0);
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_users_roles');
    }
};
