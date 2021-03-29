<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest8Tables Galleries
 */
class CreateTest8Tables extends Migration
{
    public function up()
    {
        Db::transaction(function() {
            Schema::create('october_test_galleries', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('title')->nullable();
                $table->string('status')->nullable();
                $table->boolean('party_mode')->nullable();
                $table->timestamps();
            });

            Schema::create('october_test_gallery_entity', function($table) {
                $table->engine = 'InnoDB';
                $table->unsignedInteger('gallery_id')->index('gallery_id_idx');
                $table->unsignedInteger('entity_id')->index('entity_id_idx');
                $table->string('entity_type')->index('entity_type_idx');
                $table->primary(['gallery_id', 'entity_id', 'entity_type'], 'gallery_entity_pk');
            });

        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_galleries');
        Schema::dropIfExists('october_test_gallery_entity');
    }
}
