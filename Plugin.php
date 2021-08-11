<?php namespace October\Test;

use Event;
use Backend;
use System\Classes\PluginBase;

/**
 * Test Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'October Tester',
            'description' => 'Used for testing the Relation Controller behavior and others.',
            'author'      => 'Alexey Bobkov, Samuel Georges',
            'icon'        => 'icon-child',
            'homepage'    => 'https://github.com/daftspunk/oc-test-plugin',
        ];
    }

    public function boot()
    {
        Event::listen('backend.form.extendFieldsBefore', function($widget) {
            if (!$widget->getController() instanceof \October\Test\Controllers\Countries) {
                return;
            }

            if (!$widget->model instanceof \October\Test\Models\Country) {
                return;
            }

            $widget->tabs['fields']['itemprop_name'] = [
                'label' => 'Itemprop name',
                'tab' => 'Characters',
                'comment' => 'Recommended length: 60 characters',
                'span' => 'left',
                'type' => 'text',
                'size' => 'huge',
                'language' => 'twig',
            ];

            // ...
        });

        \October\Test\Models\Country::extend(function($model) {
            if (!$model->propertyExists('translatable')) {
                $model->addDynamicProperty('translatable', []);
            }

            $model->translatable = array_merge($model->translatable, [
                'itemprop_name',
            ]);
        });

    }

    public function registerPermissions()
    {
        return [
            'october.test.access_plugin' => [
                'label' => 'Allow access to the plugin',
                'tab' => 'October Tester',
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
            'test' => [
                'label'    => 'Playground',
                'url'      => Backend::url('october/test/people'),
                'icon'     => 'icon-child',
                'order'    => 200,
                'permissions' => ['october.test.access_plugin'],

                'sideMenu' => [
                    'people'    => [
                        'label' => 'People',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/people'),
                    ],
                    'posts'     => [
                        'label' => 'Posts',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/posts'),
                    ],
                    'users'     => [
                        'label' => 'Users',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/users'),
                    ],
                    'countries' => [
                        'label' => 'Countries',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/countries'),
                    ],
                    'reviews'   => [
                        'label' => 'Reviews',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/reviews'),
                    ],
                    'galleries' => [
                        'label' => 'Galleries',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/galleries'),
                    ],
                    'trees'     => [
                        'label' => 'Trees',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/trees'),
                    ],
                    'pages'     => [
                        'label' => 'Pages',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/pages'),
                    ],
                    'cities' => [
                        'label' => 'Cities',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/cities'),
                    ],
                    'locations' => [
                        'label' => 'Locations',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/locations'),
                    ],
                ],
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'October\Test\FormWidgets\TimeChecker' => [
                'code' => 'timecheckertest',
            ],
        ];
    }
}
