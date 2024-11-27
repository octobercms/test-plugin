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
            $table->integer('company_id')->nullable()->unsigned();
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('site_root_id')->nullable()->unsigned();
            $table->boolean('bulk_pricing')->default(0)->nullable();
            $table->string('garbage')->nullable();
            $table->text('prices')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('october_test_product_categories', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('site_id')->nullable()->unsigned();
            $table->integer('site_root_id')->nullable()->unsigned();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_products_related_products', function($table) {
            $table->integer('product_id')->unsigned();
            $table->integer('related_product_id')->unsigned();
            $table->string('group_name')->nullable();
            $table->primary(['product_id', 'related_product_id']);
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

        Schema::create('october_test_products_members', function($table) {
            $table->integer('product_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->primary(['product_id', 'member_id']);
        });

        Schema::create('october_test_companies', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('preset_icon')->nullable();
            $table->string('preset_locales')->nullable();
            $table->string('preset_locales_icons')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->multisite();
        });

        Schema::create('october_test_orders', function($table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('price', 15, 2)->default(0)->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_orders_products', function($table) {
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->primary(['order_id', 'product_id']);
        });

        Schema::create('october_test_product_offers', function($table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('product_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('october_test_product_offer_stocks', function($table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('offer_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('october_test_product_offer_stock_leads', function($table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('stock_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_products');
        Schema::dropIfExists('october_test_product_categories');
        Schema::dropIfExists('october_test_products_categories');
        Schema::dropIfExists('october_test_products_related_products');
        Schema::dropIfExists('october_test_products_locations');
        Schema::dropIfExists('october_test_products_members');
        Schema::dropIfExists('october_test_companies');
        Schema::dropIfExists('october_test_orders');
        Schema::dropIfExists('october_test_orders_products');
        Schema::dropIfExists('october_test_product_offers');
        Schema::dropIfExists('october_test_product_offer_stocks');
        Schema::dropIfExists('october_test_product_offer_stock_leads');
    }
};
