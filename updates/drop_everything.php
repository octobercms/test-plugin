<?php namespace October\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class DropEverything extends Migration
{
    public function up()
    {
        Schema::dropIfExists('october_test_locations');
        Schema::dropIfExists('october_test_cities');
        Schema::dropIfExists('october_test_gallery_entity');
        Schema::dropIfExists('october_test_galleries');
        Schema::dropIfExists('october_test_galleries_countries');
        Schema::dropIfExists('october_test_comments');
        Schema::dropIfExists('october_test_people');
        Schema::dropIfExists('october_test_phones');
        Schema::dropIfExists('october_test_countries');
        Schema::dropIfExists('october_test_countries_types');
        Schema::dropIfExists('october_test_plugins');
        Schema::dropIfExists('october_test_reviews');
        Schema::dropIfExists('october_test_posts');
        Schema::dropIfExists('october_test_roles');
        Schema::dropIfExists('october_test_people_roles');
        Schema::dropIfExists('october_test_themes');
        Schema::dropIfExists('october_test_users');
        Schema::dropIfExists('october_test_users_roles');
        Schema::dropIfExists('october_test_members');
        Schema::dropIfExists('october_test_categories');
        Schema::dropIfExists('october_test_channels');
        Schema::dropIfExists('october_test_related_channels');
        Schema::dropIfExists('october_test_meta');
        Schema::dropIfExists('october_test_attributes');
        Schema::dropIfExists('october_test_repeater_items');
        Schema::dropIfExists('october_test_tags');
        Schema::dropIfExists('october_test_posts_tags');
        Schema::dropIfExists('october_test_pages');
        Schema::dropIfExists('october_test_layouts');
    }

    public function down()
    {
    }
}
