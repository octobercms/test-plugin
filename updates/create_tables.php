<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{

    public function up()
    {
        /*
         * Test 1: People
         */

        Schema::create('october_test_people', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('bio')->nullable();
            $table->datetime('birth')->nullable();
            $table->time('birthtime')->nullable();
            $table->date('birthdate')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_phones', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('brand')->nullable();
            $table->integer('person_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        /*
         * Test 2: Posts
         */

        Schema::create('october_test_posts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_comments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->integer('post_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        /*
         * Test 3: Users
         */

        Schema::create('october_test_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username')->nullable();
            $table->integer('security_code')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_roles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('october_test_users_roles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->primary(['user_id', 'role_id']);
        });

        /*
         * Test 4: Countries
         */

        Schema::create('october_test_countries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('pages')->nullable();
            $table->timestamps();
        });

        /*
         * Test 5: Staff & Orders
         */

        Schema::create('october_test_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('october_test_photos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('october_test_staffs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('october_test_comments');
        Schema::dropIfExists('october_test_people');
        Schema::dropIfExists('october_test_phones');
        Schema::dropIfExists('october_test_countries');
        Schema::dropIfExists('october_test_orders');
        Schema::dropIfExists('october_test_photos');
        Schema::dropIfExists('october_test_posts');
        Schema::dropIfExists('october_test_roles');
        Schema::dropIfExists('october_test_people_roles');
        Schema::dropIfExists('october_test_staffs');
        Schema::dropIfExists('october_test_users');
        Schema::dropIfExists('october_test_users_roles');
    }

}
