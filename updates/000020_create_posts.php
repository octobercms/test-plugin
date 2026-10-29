<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_posts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->text('content_md')->nullable();
            $table->text('content_html')->nullable();
            $table->text('tags_array')->nullable();
            $table->string('tags_string')->nullable();
            $table->text('tags_array_id')->nullable();
            $table->string('tags_string_id')->nullable();
            $table->text('tags_inline_options')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('status_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_posts');
    }
};
