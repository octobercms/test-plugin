<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_reviews', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('product');
            $table->text('content')->nullable();
            $table->string('breakdown_type')->nullable();
            $table->text('breakdown')->nullable();
            $table->text('meta')->nullable();
            $table->boolean('is_positive')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('feature_color')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_reviews');
    }
};
