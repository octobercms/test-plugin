<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->mediumText('content')->nullable();
            $table->text('description')->nullable();
            $table->text('featured_page')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            // Testing a belongsTo Tailor entry, which uses unsignedInteger to match the increments id of Tailor records
            $table->unsignedInteger('author_id')->nullable()->index();
            $table->unsignedBigInteger('location_id')->nullable()->index();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->boolean('bulk_pricing')->default(false)->nullable();
            // Testing a field added at runtime by Products::formExtendFields
            $table->string('extended_note')->nullable();
            $table->text('prices')->nullable();
            $table->integer('site_id')->nullable()->index();
            $table->unsignedBigInteger('site_root_id')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products');
    }
};
