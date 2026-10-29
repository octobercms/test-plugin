<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('october_test_gallery_entity', function (Blueprint $table) {
            // Testing a polymorphic pivot with a pivot column, see Post::$morphToMany and Gallery::$morphedByMany
            $table->unsignedBigInteger('gallery_id')->index();
            $table->unsignedBigInteger('entity_id')->index();
            $table->string('entity_type')->index();
            $table->decimal('commission_amount', 15, 2)->nullable();
            $table->primary(['gallery_id', 'entity_id', 'entity_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_gallery_entity');
    }
};
