<?php namespace October\Test\Tests;

use Schema;
use PluginTestCase;

/**
 * DatabaseMigrationTest validates plugin migrations create all expected tables
 */
class DatabaseMigrationTest extends PluginTestCase
{
    /**
     * setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->migrateDatabase();
    }

    /**
     * @dataProvider tableProvider
     */
    public function testTableExists(string $tableName)
    {
        $this->assertTrue(
            Schema::hasTable($tableName),
            "Table '{$tableName}' should exist after migration"
        );
    }

    /**
     * tableProvider returns all expected plugin tables
     */
    public static function tableProvider(): array
    {
        return [
            'people' => ['october_test_people'],
            'phones' => ['october_test_phones'],
            'posts' => ['october_test_posts'],
            'comments' => ['october_test_comments'],
            'tags' => ['october_test_tags'],
            'posts_tags' => ['october_test_posts_tags'],
            'users' => ['october_test_users'],
            'roles' => ['october_test_roles'],
            'users_roles' => ['october_test_users_roles'],
            'countries' => ['october_test_countries'],
            'cities' => ['october_test_cities'],
            'locations' => ['october_test_locations'],
            'reviews' => ['october_test_reviews'],
            'plugins' => ['october_test_plugins'],
            'themes' => ['october_test_themes'],
            'members' => ['october_test_members'],
            'categories' => ['october_test_categories'],
            'channels' => ['october_test_channels'],
            'related_channels' => ['october_test_related_channels'],
            'galleries' => ['october_test_galleries'],
            'gallery_entity' => ['october_test_gallery_entity'],
            'pages' => ['october_test_pages'],
            'layouts' => ['october_test_layouts'],
            'products' => ['october_test_products'],
            'product_categories' => ['october_test_product_categories'],
            'products_categories' => ['october_test_products_categories'],
            'products_locations' => ['october_test_products_locations'],
            'meta' => ['october_test_meta'],
            'attributes' => ['october_test_attributes'],
            'countries_types' => ['october_test_countries_types'],
            'repeater_items' => ['october_test_repeater_items'],
        ];
    }

    /**
     * testPeopleTableHasExpectedColumns
     */
    public function testPeopleTableHasExpectedColumns()
    {
        $this->assertTrue(Schema::hasColumn('october_test_people', 'name'));
        $this->assertTrue(Schema::hasColumn('october_test_people', 'preferred_name'));
        $this->assertTrue(Schema::hasColumn('october_test_people', 'bio'));
        $this->assertTrue(Schema::hasColumn('october_test_people', 'birth'));
    }

    /**
     * testPostsTableHasExpectedColumns
     */
    public function testPostsTableHasExpectedColumns()
    {
        $this->assertTrue(Schema::hasColumn('october_test_posts', 'name'));
        $this->assertTrue(Schema::hasColumn('october_test_posts', 'slug'));
        $this->assertTrue(Schema::hasColumn('october_test_posts', 'content_html'));
    }

    /**
     * testUsersTableHasExpectedColumns
     */
    public function testUsersTableHasExpectedColumns()
    {
        $this->assertTrue(Schema::hasColumn('october_test_users', 'username'));
        $this->assertTrue(Schema::hasColumn('october_test_users', 'security_code'));
    }

    /**
     * testProductsTableHasExpectedColumns
     */
    public function testProductsTableHasExpectedColumns()
    {
        $this->assertTrue(Schema::hasColumn('october_test_products', 'title'));
        $this->assertTrue(Schema::hasColumn('october_test_products', 'slug'));
        $this->assertTrue(Schema::hasColumn('october_test_products', 'price'));
        $this->assertTrue(Schema::hasColumn('october_test_products', 'deleted_at'));
    }
}
