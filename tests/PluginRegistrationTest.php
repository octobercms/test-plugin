<?php namespace October\Test\Tests;

use PluginTestCase;
use System\Classes\PluginManager;

/**
 * PluginRegistrationTest validates the plugin registration file
 */
class PluginRegistrationTest extends PluginTestCase
{
    /**
     * testPluginDetails
     */
    public function testPluginDetails()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $this->assertNotNull($plugin);

        $details = $plugin->pluginDetails();
        $this->assertArrayHasKey('name', $details);
        $this->assertArrayHasKey('description', $details);
        $this->assertArrayHasKey('author', $details);
        $this->assertArrayHasKey('icon', $details);
        $this->assertEquals('October Tester', $details['name']);
    }

    /**
     * testPluginRegistersPermissions
     */
    public function testPluginRegistersPermissions()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $permissions = $plugin->registerPermissions();

        $this->assertIsArray($permissions);
        $this->assertArrayHasKey('october.test.access_plugin', $permissions);
    }

    /**
     * testPluginRegistersNavigation
     */
    public function testPluginRegistersNavigation()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $navigation = $plugin->registerNavigation();

        $this->assertIsArray($navigation);
        $this->assertArrayHasKey('test', $navigation);
        $this->assertArrayHasKey('sideMenu', $navigation['test']);
    }

    /**
     * testPluginRegistersComponents
     */
    public function testPluginRegistersComponents()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $components = $plugin->registerComponents();

        $this->assertIsArray($components);
        $this->assertArrayHasKey(\October\Test\Components\KitchenSink::class, $components);
        $this->assertArrayHasKey(\October\Test\Components\RemoveIndex::class, $components);
    }

    /**
     * testPluginRegistersSettings
     */
    public function testPluginRegistersSettings()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $settings = $plugin->registerSettings();

        $this->assertIsArray($settings);
        $this->assertArrayHasKey('test', $settings);
        $this->assertEquals(\October\Test\Models\Setting::class, $settings['test']['class']);
    }

    /**
     * testPluginRegistersMailTemplates
     */
    public function testPluginRegistersMailTemplates()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $mail = $plugin->registerMailTemplates();

        $this->assertIsArray($mail);
        $this->assertArrayHasKey('templates', $mail);
        $this->assertArrayHasKey('layouts', $mail);
        $this->assertArrayHasKey('partials', $mail);
    }

    /**
     * testPluginRegistersReportWidgets
     */
    public function testPluginRegistersReportWidgets()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $widgets = $plugin->registerReportWidgets();

        $this->assertIsArray($widgets);
        $this->assertArrayHasKey(\October\Test\ReportWidgets\ClearCache::class, $widgets);
        $this->assertArrayHasKey(\October\Test\ReportWidgets\TestCharts::class, $widgets);
    }

    /**
     * testPluginRegistersFormWidgets
     */
    public function testPluginRegistersFormWidgets()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $widgets = $plugin->registerFormWidgets();

        $this->assertIsArray($widgets);
        $this->assertArrayHasKey(\October\Test\FormWidgets\TimeChecker::class, $widgets);
    }

    /**
     * testPluginRegistersFilterWidgets
     */
    public function testPluginRegistersFilterWidgets()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $widgets = $plugin->registerFilterWidgets();

        $this->assertIsArray($widgets);
        $this->assertArrayHasKey(\October\Test\FilterWidgets\Discount::class, $widgets);
        $this->assertArrayHasKey(\October\Test\FilterWidgets\InlineSearch::class, $widgets);
        $this->assertArrayHasKey(\October\Test\FilterWidgets\InlineBalloon::class, $widgets);
    }
}
