<?php

use October\Rain\Database\Updates\Migration;

/**
 * Migration for Test 9 (Migration)
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_products', function($table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->mediumText('content')->nullable();
            $table->text('description')->nullable();
            $table->text('featured_page')->nullable();
            $table->decimal('price', 15, 2)->default(0)->nullable();
            $table->integer('author_id')->nullable()->unsigned();
            $table->integer('location_id')->nullable()->unsigned();
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('site_root_id')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('october_test_product_categories', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('site_root_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('october_test_products_categories', function($table) {
            $table->integer('product_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['product_id', 'category_id']);
        });

        Schema::create('october_test_products_locations', function($table) {
            $table->integer('product_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->primary(['product_id', 'location_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products');
        Schema::dropIfExists('october_test_product_categories');
        Schema::dropIfExists('october_test_products_categories');
        Schema::dropIfExists('october_test_products_locations');
    }
};
