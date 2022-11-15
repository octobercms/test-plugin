<?php namespace October\Test\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTest3Tables Users
 */
class CreateTest3Tables extends Migration
{
    public function up()
    {
        Schema::create('october_test_users', function($table) {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->integer('security_code')->nullable();
            $table->string('media_image')->nullable();
            $table->string('media_file')->nullable();
            $table->string('media_folder')->nullable();
            $table->mediumText('media_images')->nullable();
            $table->mediumText('media_files')->nullable();
            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::create('october_test_roles', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_users_roles', function($table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->primary(['user_id', 'role_id']);
            $table->string('clearance_level')->nullable();
            $table->boolean('is_executive')->default(false);
            $table->smallInteger('evolution')->nullable()->unsigned()->default(0);
            $table->integer('salary')->nullable()->unsigned()->default(0);
            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_users');
        Schema::dropIfExists('october_test_roles');
        Schema::dropIfExists('october_test_users_roles');
    }
}
