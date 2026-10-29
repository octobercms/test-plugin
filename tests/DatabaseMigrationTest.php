<?php namespace October\Test\Tests;

use Schema;
use PluginTestCase;
use ReflectionClass;
use System\Classes\VersionManager;

/**
 * DatabaseMigrationTest checks the plugin migrations create every table and that rolling them back removes each one.
 */
class DatabaseMigrationTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testTableExists checks the migrations have created the table.
     *
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
     * tableProvider lists every table created by the migrations in the updates directory.
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
            'country_brothers' => ['october_test_country_brothers'],
            'galleries_countries' => ['october_test_galleries_countries'],
            'page_banners' => ['october_test_page_banners'],
            'products_related_products' => ['october_test_products_related_products'],
            'products_members' => ['october_test_products_members'],
            'products_stream_records' => ['october_test_products_stream_records'],
            'companies' => ['october_test_companies'],
            'orders' => ['october_test_orders'],
            'orders_products' => ['october_test_orders_products'],
            'order_items' => ['october_test_order_items'],
            'product_offers' => ['october_test_product_offers'],
            'product_offer_stocks' => ['october_test_product_offer_stocks'],
            'product_offer_stock_leads' => ['october_test_product_offer_stock_leads'],
        ];
    }

    /**
     * testModelTablesExist checks every model that declares a table points at one the migrations create.
     */
    public function testModelTablesExist()
    {
        foreach (glob(plugins_path('october/test/models/*.php')) as $path) {
            $class = 'October\Test\Models\\' . basename($path, '.php');
            $reflection = new ReflectionClass($class);

            if (!$reflection->hasProperty('table') || $reflection->getProperty('table')->getDeclaringClass()->getName() !== $class) {
                continue;
            }

            $table = (new $class)->getTable();
            $this->assertTrue(Schema::hasTable($table), "Model [{$class}] uses table [{$table}], which does not exist");
        }
    }

    /**
     * testRollbackRemovesEveryTable checks each migration's down() drops what its up() created.
     */
    public function testRollbackRemovesEveryTable()
    {
        VersionManager::instance()->removePlugin('October.Test');

        $leftover = array_filter(
            Schema::getTableListing(Schema::getCurrentSchemaName(), false),
            fn($table) => str_starts_with($table, 'october_test_')
        );

        $this->assertEmpty($leftover, 'Tables left after rollback: ' . implode(', ', $leftover));
    }
}
