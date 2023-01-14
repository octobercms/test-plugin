<?php namespace October\Test\Tests;

use Schema;
use PluginTestCase;

/**
 * ExampleDatabaseTest
 */
class ExampleDatabaseTest extends PluginTestCase
{
    /**
     * setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        // Migrate everything
        $this->migrateDatabase();
    }

    /**
     * testDatabaseAvailable
     */
    public function testDatabaseAvailable()
    {
        // Core
        $this->assertTrue(Schema::hasTable('migrations'));

        // Module
        $this->assertTrue(Schema::hasTable('system_files'));

        // Plugin
        $this->assertTrue(Schema::hasTable('october_test_people'));
    }
}
