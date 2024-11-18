<?php namespace October\Test;

use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'October Tester',
            'description' => 'Used for testing the Relation Controller behavior and others.',
            'author' => 'Alexey Bobkov, Samuel Georges',
            'icon' => 'icon-child',
            'homepage' => 'https://github.com/daftspunk/oc-test-plugin',
        ];
    }

    /**
     * register the service provider
     */
    public function register()
    {
        $this->registerConsoleCommand('test.seed-posts', \October\Test\Console\SeedPosts::class);
    }

    /**
     * boot the service provider
     */
    public function boot()
    {
        $this->callAfterResolving('validator', function ($validator) {
            $validator->extend('uppercase', \October\Test\Classes\UppercaseRule::class);
            $validator->extend('betwixt', \October\Test\Classes\BetwixtRule::class);
        });

        \October\Test\Models\Page::extend(function($model) {
            $model->translatable = array_merge($model->translatable, [
                'parent_id',
            ]);
        });

        // \Event::listen('backend.brand.getPalettePresets', function(&$presets) {
        //     unset($presets['punch']);
        // });

        // \Backend\FormWidgets\RichEditor::extend(function($controller) {
        //     $controller->addJs('/plugins/october/test/assets/js/custom-button.js');
        // });


        \Event::listen('backend.form.extendFields', function (\Backend\Widgets\Form $widget) {
            if (!$widget->getController() instanceof \October\Test\Controllers\Products || $widget->isNested) {
                return;
            }

            if (!$widget->model instanceof \October\Test\Models\Product) {
                return;
            }

            $widget->addField('garbage', [
                'label' => 'Garbage field'
            ]);
        });
    }

    /**
     * registerReportWidgets
     */
    public function registerReportWidgets()
    {
        return [];

        return [
            // Report Widget
            \Backend\ReportWidgets\Welcome::class => [
                'label' => 'backend::lang.dashboard.welcome.widget_title_default',
                'context' => 'dashboard'
            ],

            // Vue Report Widget
            \October\Test\VueComponents\MyCustomWidget::class => [
                'label' => 'Custom Widget',
                'group' => 'Acme Author',
            ]
        ];
    }

    public function registerContentFields()
    {
        return [
            \October\Test\ContentFields\MyContentField::class => 'mycontentfield'
        ];
    }

    /**
     * registerMailTemplates
     */
    public function registerMailTemplates()
    {
        return [
            'templates' => [
                'october.test::mail.test-message'
            ],
            'layouts' => [
                'test' => 'october.test::mail.test-layout'
            ],
            'partials' => [
                'test' => 'october.test::mail.test-partial'
            ]
        ];
    }

    /**
     * registerPermissions
     */
    public function registerPermissions()
    {
        return [
            'october.test.access_plugin' => [
                'label' => 'Allow access to the plugin',
                'tab' => 'October Tester',
            ]
        ];
    }

    /**
     * registerComponents
     */
    public function registerComponents()
    {
        return [
            \October\Test\Components\KitchenSink::class => 'kitchenSink',
            \October\Test\Components\RemoveIndex::class => 'removeIndex',
        ];
    }

    public function registerPageSnippets()
    {
        return [
            \October\Test\Components\KitchenSink::class => 'weather'
        ];
    }

    /**
     * registerFilterWidgets
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
     * registerNavigation
     */
    public function registerNavigation()
    {
        return [
            'test' => [
                'label' => 'Playground',
                'url' => Backend::url('october/test/people'),
                'icon' => 'icon-child',
                'order' => 198,
                'permissions' => ['october.test.access_plugin'],

                'sideMenu' => [
                    'people_create' => [
                        'label' => 'New Person',
                        'icon' => 'icon-plus',
                        'url' => Backend::url('october/test/people/create'),
                        'itemType' => 'primary',
                    ],
                    'people_ruler' => [
                        'itemType' => 'ruler',
                    ],
                    'people' => [
                        'label' => 'People',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/people'),
                    ],
                    'posts' => [
                        'label' => 'Posts',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/posts'),
                    ],
                    'users' => [
                        'label' => 'Users',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/users'),
                    ],
                    '_ruler1' => [
                        'itemType' => 'ruler',
                    ],
                    '_section1' => [
                        'itemType' => 'section',
                        'label' => 'Advanced',
                    ],
                    'locations' => [
                        'label' => 'Locations',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/locations'),
                    ],
                    'reviews' => [
                        'label' => 'Reviews',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/reviews'),
                    ],
                    'galleries' => [
                        'label' => 'Galleries',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/galleries'),
                    ],
                    '_ruler2' => [
                        'itemType' => 'ruler',
                    ],
                    '_section2' => [
                        'itemType' => 'section',
                        'label' => 'Structures',
                    ],
                    'trees' => [
                        'label' => 'Trees',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/trees'),
                    ],
                    'pages' => [
                        'label' => 'Pages',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/pages'),
                    ],
                    'products' => [
                        'label' => 'Products',
                        'icon' => 'icon-database',
                        'url' => Backend::url('october/test/products'),
                    ],
                ],
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'test' => [
                'label' => 'Playground Settings',
                'description' => 'Settings for the test plugin',
                'category' => SettingsManager::CATEGORY_MISC,
                'icon' => 'icon-child',
                'class' => \October\Test\Models\Setting::class,
                'order' => 500,
                'keywords' => 'settings october test',
                'permissions' => ['october.test.manage_settings']
            ]
        ];
    }

    /**
     * registerFormWidgets
     */
    public function registerFormWidgets()
    {
        return [
            \October\Test\FormWidgets\TimeChecker::class => [
                'code' => 'timecheckertest',
            ],
        ];
    }

    /**
     * registerSchedule
     */
    public function registerSchedule($schedule)
    {
        $schedule->command('cache:clear')->everyMinute();
    }
}
