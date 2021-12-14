<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest5Tables Reviews
 */
class CreateTest5Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_meta', function($table) {
            $table->increments('id')->unsigned();
            $table->integer('taggable_id')->unsigned()->index()->nullable();
            $table->string('taggable_type')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('robot_index')->nullable();
            $table->string('robot_follow')->nullable();
        });

        Schema::create('october_test_reviews', function($table) {
            $table->increments('id');
            $table->string('product_type')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->text('content')->nullable();
            $table->string('breakdown_type')->nullable();
            $table->text('breakdown')->nullable();
            $table->boolean('is_positive')->nullable();
            $table->string('feature_color')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_plugins', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_themes', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_meta');
        Schema::dropIfExists('october_test_reviews');
        Schema::dropIfExists('october_test_plugins');
        Schema::dropIfExists('october_test_themes');
    }
}
