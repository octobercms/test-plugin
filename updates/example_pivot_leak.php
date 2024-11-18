<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * AddPivotProductsRelated Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::table('october_test_products', function(Blueprint $table) {
            $table->string('garbage')->nullable();
        });
        Schema::table('october_test_products_related_products', function(Blueprint $table) {
            $table->string('group_name')->nullable();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::table('october_test_products', function(Blueprint $table) {
            $table->dropColumn('garbage');
        });

        Schema::table('october_test_products_related_products', function(Blueprint $table) {
            $table->dropColumn('group_name');
        });
    }
};
