<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOctoberTestFriends extends Migration
{
    public function up()
    {
        Schema::create('october_test_friends', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->integer('friend_id');
            $table->smallInteger('status')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('october_test_friends');
    }
}