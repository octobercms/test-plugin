<?php namespace October\Test;

use Cache;
use Event;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * Plugin registers every feature of the October Test playground with the system.
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails returns information about this plugin.
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => "October Test",
            'description' => "Demonstrates October CMS features, each one written as reference code.",
            'author' => 'Alexey Bobkov, Samuel Georges',
            'icon' => 'ph ph-person-simple',
            'homepage' => 'https://github.com/octobercms/test-plugin',
        ];
    }

    /**
     * register adds the console command and the custom validation rules.
     */
    public function register()
    {
        $this->registerConsoleCommand('test.seed-posts', \October\Test\Console\SeedPosts::class);
        $this->registerValidationRule('all_caps', \October\Test\Classes\UppercaseRule::class);
        $this->registerValidationRule('betwixt', \October\Test\Classes\BetwixtRule::class);
    }

    /**
     * boot subscribes to core events through the ExtendCoreFeatures class.
     */
    public function boot()
    {
        Event::subscribe(\October\Test\Classes\ExtendCoreFeatures::class);
    }

    /**
     * registerDashboards registers the dashboard widgets and data sources provided by this plugin.
     */
    public function registerDashboards()
    {
        return [
            'widgets' => [
                \October\Test\ReportWidgets\ClearCache::class => [
                    'label' => "Clear Cache",
                    'group' => "Acme Author",
                    'permissions' => ['october.test.manage_settings'],
                ],
                \October\Test\ReportWidgets\TestCharts::class => [
                    'label' => "Test Charts",
                    'group' => "Acme Author",
                    'permissions' => ['october.test.access_plugin'],
                ],
                \October\Test\VueComponents\MyCustomWidget::class => [
                    'label' => "Custom Widget",
                    'group' => "Acme Author",
                    'permissions' => ['october.test.access_plugin'],
                ],
            ],
            'dataSources' => [
                \October\Test\Classes\LocationDataSource::class => [
                    'label' => "Locations",
                    'permissions' => ['october.test.access_plugin'],
                ],
            ],
        ];
    }

    /**
     * registerContentFields registers the Tailor content field provided by this plugin.
     */
    public function registerContentFields()
    {
        return [
            \October\Test\ContentFields\MyContentField::class => 'mycontentfield'
        ];
    }

    /**
     * registerMailTemplates registers the mail templates that can be customized in the backend.
     */
    public function registerMailTemplates()
    {
        return [
            'october.test::mail.test-message'
        ];
    }

    /**
     * registerMailLayouts registers the mail layout used by the test message.
     */
    public function registerMailLayouts()
    {
        return [
            'test-layout' => 'october.test::mail.test-layout'
        ];
    }

    /**
     * registerMailPartials registers the mail partial used by the test message.
     */
    public function registerMailPartials()
    {
        return [
            'test-partial' => 'october.test::mail.test-partial'
        ];
    }

    /**
     * registerPermissions registers the permissions that guard the playground pages and settings.
     */
    public function registerPermissions()
    {
        return [
            'october.test.access_plugin' => [
                'label' => "Access Plugin",
                'tab' => "October Test",
                'order' => 100,
            ],
            'october.test.manage_products' => [
                'label' => "Manage Products & Orders",
                'tab' => "October Test",
                'order' => 200,
            ],
            'october.test.reorder_trees' => [
                'label' => "Reorder Trees",
                'tab' => "October Test",
                'order' => 300,
            ],
            'october.test.manage_settings' => [
                'label' => "Manage Settings",
                'tab' => "October Test",
                'order' => 400,
            ],
        ];
    }

    /**
     * registerComponents registers the CMS components used by the test theme.
     */
    public function registerComponents()
    {
        return [
            \October\Test\Components\KitchenSink::class => 'kitchenSink',
            \October\Test\Components\InlineData::class => 'inlineData',
            \October\Test\Components\VueTester::class => 'vueTester',
        ];
    }

    /**
     * registerPageSnippets registers the components that can be inserted into page content as snippets.
     */
    public function registerPageSnippets()
    {
        return [
            \October\Test\Components\KitchenSink::class => 'kitchenSink',
            \October\Test\Components\InlineData::class => 'inlineData'
        ];
    }

    /**
     * registerFilterWidgets registers the custom list filter widgets.
     */
    public function registerFilterWidgets()
    {
        return [
            \October\Test\FilterWidgets\Discount::class => 'discount',
            \October\Test\FilterWidgets\InlineSearch::class => 'inlinesearch',
            \October\Test\FilterWidgets\InlineBalloon::class => 'inlineballoon',
        ];
    }

    /**
     * registerNavigation registers the Playground main menu item and its side menu.
     */
    public function registerNavigation()
    {
        return [
            'test' => [
                'label' => "Playground",
                'url' => Backend::url('october/test/people'),
                'icon' => 'ph ph-person-simple',
                'order' => 198,
                'permissions' => ['october.test.access_plugin'],

                'sideMenu' => [
                    'people_create' => [
                        'label' => "New Person",
                        'icon' => 'ph ph-plus',
                        'url' => Backend::url('october/test/people/create'),
                        'itemType' => 'primary',
                        'visibleOn' => 'people',
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'people_ruler' => [
                        'itemType' => 'ruler',
                        'visibleOn' => 'people',
                    ],
                    'people' => [
                        'label' => "People",
                        'icon' => 'ph ph-users',
                        'url' => Backend::url('october/test/people'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'posts' => [
                        'label' => "Posts",
                        'icon' => 'ph ph-article',
                        'url' => Backend::url('october/test/posts'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'users' => [
                        'label' => "Users",
                        'icon' => 'ph ph-user-circle',
                        'url' => Backend::url('october/test/users'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    '_ruler1' => [
                        'itemType' => 'ruler',
                    ],
                    '_section1' => [
                        'itemType' => 'section',
                        'label' => "Advanced",
                    ],
                    'locations' => [
                        'label' => "Locations",
                        'icon' => 'ph ph-map-pin',
                        'url' => Backend::url('october/test/locations'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'reviews' => [
                        'label' => "Reviews",
                        'icon' => 'ph ph-star',
                        'url' => Backend::url('october/test/reviews'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'galleries' => [
                        'label' => "Galleries",
                        'icon' => 'ph ph-images',
                        'url' => Backend::url('october/test/galleries'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    '_ruler2' => [
                        'itemType' => 'ruler',
                    ],
                    '_section2' => [
                        'itemType' => 'section',
                        'label' => "Structures",
                    ],
                    'trees' => [
                        'label' => "Trees",
                        'icon' => 'ph ph-tree-structure',
                        'url' => Backend::url('october/test/trees'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'pages' => [
                        'label' => "Pages",
                        'icon' => 'ph ph-files',
                        'url' => Backend::url('october/test/pages'),
                        'permissions' => ['october.test.access_plugin'],
                    ],
                    'products' => [
                        'label' => "Products",
                        'icon' => 'ph ph-package',
                        'url' => Backend::url('october/test/products'),
                        'permissions' => ['october.test.manage_products'],
                    ],
                ],
            ],
        ];
    }

    /**
     * registerSettings registers the Playground settings page.
     */
    public function registerSettings()
    {
        return [
            'test' => [
                'label' => "Playground Settings",
                'description' => "Settings for the October Test plugin.",
                'category' => SettingsManager::CATEGORY_MISC,
                'icon' => 'ph ph-person-simple',
                'class' => \October\Test\Models\Setting::class,
                'order' => 500,
                'keywords' => 'settings october test',
                'permissions' => ['october.test.manage_settings']
            ]
        ];
    }

    /**
     * registerFormWidgets registers the custom form widget.
     */
    public function registerFormWidgets()
    {
        return [
            \October\Test\FormWidgets\TimeChecker::class => 'timecheckertest',
        ];
    }

    /**
     * registerSchedule records an hourly heartbeat in the cache to test plugin scheduling.
     */
    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            Cache::put('october.test.heartbeat', now()->toDateTimeString());
        })->name('october.test.heartbeat')->hourly();
    }
}
