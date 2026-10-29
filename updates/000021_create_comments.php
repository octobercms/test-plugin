<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_comments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->text('content')->nullable();
            $table->text('content_md')->nullable();
            $table->text('content_html')->nullable();
            $table->text('breakdown')->nullable();
            $table->text('mood')->nullable();
            $table->text('quotes')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->unsignedBigInteger('parent_comment_id')->nullable()->index();
            $table->unsignedBigInteger('post_id')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_comments');
    }
};
