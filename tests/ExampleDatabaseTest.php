<?php namespace October\Test\Tests;

use PluginTestCase;

class ExampleDatabaseTest extends PluginTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Migrate everything
        $this->migrateDatabase();
    }

    public function testDatabaseAvailable()
    {
        // Core
        $this->assertTrue(\Schema::hasTable('migrations'));

        // Module
        $this->assertTrue(\Schema::hasTable('system_files'));

        // Plugin
        $this->assertTrue(\Schema::hasTable('october_test_people'));
    }
}
