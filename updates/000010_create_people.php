<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

// Testing an anonymous migration class declared with parentheses
return new class() extends Migration
{
    public function up()
    {
        Schema::create('october_test_people', function (Blueprint $table) {
            $table->id();
            // Testing a hasOne relation keyed on a column other than id, see Person::$hasOne alt_phone
            $table->unsignedBigInteger('alt_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('preferred_name')->nullable();
            $table->string('email')->nullable();
            $table->string('api_key')->nullable();
            $table->string('bio')->nullable();
            $table->decimal('expenses', 15, 2)->nullable();
            $table->dateTime('birth')->nullable();
            $table->time('birthtime')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('favcolor')->nullable();
            $table->text('hobbies')->nullable();
            $table->text('sports')->nullable();
            // Testing a nullable boolean, so an empty value saves as null instead of false
            $table->boolean('is_married')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_people');
    }
};
