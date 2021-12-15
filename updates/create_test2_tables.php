<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest2Tables Posts
 */
class CreateTest2Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_posts', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->text('content_md')->nullable();
            $table->text('content_html')->nullable();
            $table->string('tags_array')->nullable();
            $table->string('tags_string')->nullable();
            $table->string('tags_array_id')->nullable();
            $table->string('tags_string_id')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::create('october_test_comments', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->text('content_md')->nullable();
            $table->text('content_html')->nullable();
            $table->text('breakdown')->nullable();
            $table->text('mood')->nullable();
            $table->text('quotes')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('post_id')->unsigned()->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('october_test_tags', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_posts_tags', function($table) {
            $table->integer('post_id');
            $table->integer('tag_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_posts');
        Schema::dropIfExists('october_test_comments');
        Schema::dropIfExists('october_test_tags');
        Schema::dropIfExists('october_test_posts_tags');
    }
}
