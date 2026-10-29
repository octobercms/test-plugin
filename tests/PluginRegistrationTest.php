<?php namespace October\Test\Tests;

use Yaml;
use Cache;
use Validator;
use PluginTestCase;
use ReflectionClass;
use FilesystemIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use System\Classes\MailManager;
use System\Classes\PluginManager;
use System\Models\MailLayout;
use System\Models\MailTemplate;
use Illuminate\Console\Scheduling\Schedule;

/**
 * PluginRegistrationTest validates the plugin registration file.
 */
class PluginRegistrationTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testPluginDetails checks the plugin is found by its identifier and describes itself with a name, description, author and icon.
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
        $this->assertEquals('October Test', $details['name']);
    }

    /**
     * testPluginRegistersPermissions checks the permission that guards the playground pages is registered.
     */
    public function testPluginRegistersPermissions()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $permissions = $plugin->registerPermissions();

        $this->assertIsArray($permissions);
        $this->assertArrayHasKey('october.test.access_plugin', $permissions);
    }

    /**
     * testReferencedPermissionsAreRegistered checks that every permission used by navigation,
     * settings, controllers and list structures is registered by the plugin.
     */
    public function testReferencedPermissionsAreRegistered()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $registered = array_keys($plugin->registerPermissions());
        $referenced = [];

        foreach ($plugin->registerNavigation() as $mainItem) {
            array_push($referenced, ...($mainItem['permissions'] ?? []));
            foreach ($mainItem['sideMenu'] ?? [] as $sideItem) {
                array_push($referenced, ...($sideItem['permissions'] ?? []));
            }
        }

        foreach ($plugin->registerSettings() as $settingItem) {
            array_push($referenced, ...($settingItem['permissions'] ?? []));
        }

        foreach ($plugin->registerDashboards() as $dashboardItems) {
            foreach ($dashboardItems as $dashboardItem) {
                array_push($referenced, ...($dashboardItem['permissions'] ?? []));
            }
        }

        foreach ($this->getControllerClasses() as $class) {
            array_push($referenced, ...((new ReflectionClass($class))->getDefaultProperties()['requiredPermissions'] ?? []));
        }

        foreach (glob(plugins_path('october/test/controllers/*/config_*list*.yaml')) as $path) {
            $config = Yaml::parseFile($path);
            array_push($referenced, ...(array) ($config['structure']['permissions'] ?? []));
        }

        $this->assertNotEmpty($referenced);

        foreach (array_unique($referenced) as $permission) {
            $this->assertContains($permission, $registered, "Permission [{$permission}] is referenced but not registered");
        }
    }

    /**
     * testEveryControllerRequiresPermissions checks each backend controller declares a non-empty requiredPermissions list, since an empty list lets any backend user open it.
     */
    public function testEveryControllerRequiresPermissions()
    {
        $classes = $this->getControllerClasses();

        $this->assertNotEmpty($classes);

        foreach ($classes as $class) {
            $permissions = (new ReflectionClass($class))->getDefaultProperties()['requiredPermissions'] ?? null;

            $this->assertIsArray($permissions, "{$class} does not declare requiredPermissions");
            $this->assertNotEmpty($permissions, "{$class} declares an empty requiredPermissions list");
        }
    }

    /**
     * testPluginDoesNotReferenceOtherPlugins keeps the plugin standalone, since it serves as reference material.
     */
    public function testPluginDoesNotReferenceOtherPlugins()
    {
        $pluginPath = realpath(plugins_path('october/test'));
        $patterns = ['/\b(rainlab|responsiv|meloncart)[\\\\.]\w+/i'];

        foreach (glob(plugins_path('*/*'), GLOB_ONLYDIR) as $otherPath) {
            if (realpath($otherPath) === $pluginPath) {
                continue;
            }

            [$author, $name] = array_slice(explode('/', str_replace('\\', '/', $otherPath)), -2);
            $patterns[] = '/\b' . preg_quote($author, '/') . '[\\\\.]' . preg_quote($name, '/') . '\b/i';
        }

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($pluginPath, FilesystemIterator::SKIP_DOTS));
        $violations = [];

        foreach ($files as $file) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($pluginPath) + 1));

            if (preg_match('#^(\.git|node_modules)/#', $relativePath)) {
                continue;
            }

            if (!in_array($file->getExtension(), ['php', 'htm', 'yaml', 'json', 'js', 'css', 'md', 'xml'])) {
                continue;
            }

            $contents = file_get_contents($file->getPathname());

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $contents, $match)) {
                    $violations[] = "{$relativePath} references [{$match[0]}]";
                }
            }
        }

        $this->assertEmpty($violations, "The plugin must not reference other plugins:\n" . implode("\n", array_unique($violations)));
    }

    /**
     * testPluginRegistersSchedule checks the hourly heartbeat task is scheduled and runs.
     */
    public function testPluginRegistersSchedule()
    {
        $schedule = new Schedule;
        PluginManager::instance()->findByIdentifier('October.Test')->registerSchedule($schedule);

        $events = $schedule->events();
        $this->assertCount(1, $events);
        $this->assertEquals('october.test.heartbeat', $events[0]->description);
        $this->assertEquals('0 * * * *', $events[0]->expression);

        $events[0]->run($this->app);
        $this->assertNotNull(Cache::get('october.test.heartbeat'));
    }

    /**
     * testPluginRegistersNavigation checks the Playground main menu item is registered with a side menu.
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
     * testPluginRegistersComponents checks the components the test theme uses are registered.
     */
    public function testPluginRegistersComponents()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $components = $plugin->registerComponents();

        $this->assertIsArray($components);
        $this->assertArrayHasKey(\October\Test\Components\KitchenSink::class, $components);
        $this->assertArrayHasKey(\October\Test\Components\VueTester::class, $components);
    }

    /**
     * testPluginRegistersSettings checks the Playground settings page is registered with its settings model.
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
     * testPluginRegistersMailTemplates checks the mail template, layout and partial use the documented registration methods.
     */
    public function testPluginRegistersMailTemplates()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');

        $this->assertEquals(['october.test::mail.test-message'], $plugin->registerMailTemplates());
        $this->assertEquals(['test-layout' => 'october.test::mail.test-layout'], $plugin->registerMailLayouts());
        $this->assertEquals(['test-partial' => 'october.test::mail.test-partial'], $plugin->registerMailPartials());
    }

    /**
     * testMailTemplateRendersWithLayoutAndPartial checks the test message renders inside its registered layout with its partial.
     */
    public function testMailTemplateRendersWithLayoutAndPartial()
    {
        // Sync only this layout, since other plugins on disk are not booted in the test environment
        $layout = new MailLayout;
        $layout->code = 'test-layout';
        $layout->fillFromCode();
        $layout->save();

        $template = MailTemplate::findOrMakeTemplate('october.test::mail.test-message');
        $html = MailManager::instance()->renderTemplate($template, ['user' => 'Neo']);

        $this->assertEquals('test-layout', $template->layout->code);
        $this->assertStringContainsString('In Layout: Neo', $html);
        $this->assertStringContainsString('In Partial: Neo', $html);
    }

    /**
     * testPluginRegistersDashboards checks the dashboard widgets and data sources are registered.
     */
    public function testPluginRegistersDashboards()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $dashboards = $plugin->registerDashboards();

        $this->assertArrayHasKey(\October\Test\ReportWidgets\ClearCache::class, $dashboards['widgets']);
        $this->assertArrayHasKey(\October\Test\ReportWidgets\TestCharts::class, $dashboards['widgets']);
        $this->assertArrayHasKey(\October\Test\VueComponents\MyCustomWidget::class, $dashboards['widgets']);
        $this->assertArrayHasKey(\October\Test\Classes\LocationDataSource::class, $dashboards['dataSources']);
    }

    /**
     * testPluginRegistersValidationRules checks the rule classes and the replacer placeholder from the rule parameter.
     */
    public function testPluginRegistersValidationRules()
    {
        $validator = Validator::make(['title' => 'lower', 'size' => 'ab'], ['title' => 'all_caps:strict', 'size' => 'betwixt:3,20']);

        $this->assertEquals('The title must be uppercase (strict mode).', $validator->errors()->first('title'));
        $this->assertEquals('The size must be between 3 and 20.', $validator->errors()->first('size'));
        $this->assertTrue(Validator::make(['title' => 'UPPER'], ['title' => 'all_caps:strict'])->passes());
    }

    /**
     * testUppercaseRuleModes checks the default mode accepts a value without letters, strict mode requires a letter, and the message names the mode.
     */
    public function testUppercaseRuleModes()
    {
        $default = Validator::make(['code' => 'Abc'], ['code' => 'all_caps']);
        $this->assertTrue($default->fails());
        $this->assertEquals('The code must be uppercase (default mode).', $default->errors()->first('code'));

        $this->assertTrue(Validator::make(['code' => 'Abc'], ['code' => 'all_caps:strict'])->fails());
        $this->assertTrue(Validator::make(['code' => '123'], ['code' => 'all_caps'])->passes());

        $strict = Validator::make(['code' => '123'], ['code' => 'all_caps:strict']);
        $this->assertTrue($strict->fails(), 'A value without letters should fail all_caps:strict');
        $this->assertEquals('The code must be uppercase (strict mode).', $strict->errors()->first('code'));
    }

    /**
     * testPluginExtendsCoreFeatures checks the event subscriber extends the Page model when the plugin boots.
     */
    public function testPluginExtendsCoreFeatures()
    {
        $this->assertContains('parent_id', (new \October\Test\Models\Page)->getTranslatableAttributes());
    }

    /**
     * testPluginRegistersFormWidgets checks the TimeChecker form widget is registered.
     */
    public function testPluginRegistersFormWidgets()
    {
        $plugin = PluginManager::instance()->findByIdentifier('October.Test');
        $widgets = $plugin->registerFormWidgets();

        $this->assertIsArray($widgets);
        $this->assertArrayHasKey(\October\Test\FormWidgets\TimeChecker::class, $widgets);
    }

    /**
     * testPluginRegistersFilterWidgets checks the Discount, InlineSearch and InlineBalloon filter widgets are registered.
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

    /**
     * getControllerClasses returns the class name of every backend controller in the plugin.
     */
    protected function getControllerClasses(): array
    {
        return array_map(
            fn($path) => 'October\Test\Controllers\\' . basename($path, '.php'),
            glob(plugins_path('october/test/controllers/*.php'))
        );
    }
}
