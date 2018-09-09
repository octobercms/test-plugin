<?php
namespace October\Test;

use App;
use Backend;
use Cms\Classes\Page as CmsPage;
use Event;
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

    public function registerNavigation()
    {
        return [
            'test' => [
                'label'    => 'Playground',
                'url'      => Backend::url('october/test/people'),
                'icon'     => 'icon-child',
                'order'    => 200,

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

    /**
     * Extend CMS Page with Repeater Field.
     *
     * @return void
     */
    public function boot()
    {
        if (App::runningInBackend()) {
            Event::listen('backend.form.extendFields', function ($widget) {
                if ($widget->isNested) {
                    return;
                }
                if (!$widget->model instanceof CmsPage) {
                    return;
                }
                $widget->addFields([
                    'settings[blocks]' => [
                        'prompt' => 'Add Content Block',
                        'type'   => 'repeater',
                        'groups' => [
                            'textarea' => [
                                'name'        => 'textarea',
                                'description' => 'Basic text field',
                                'icon'        => 'icon-file-text-o',
                                'fields'      => [
                                    'text_area' => [
                                        'label' => 'Text Content',
                                        'type'  => 'textarea',
                                        'size'  => 'large',
                                    ],
                                ],
                            ],
                            'quote'    => [
                                'name'        => 'Quote',
                                'description' => 'Quote item',
                                'icon'        => 'icon-quote-right',
                                'fields'      => [
                                    'quote_position' => [
                                        'span'    => 'auto',
                                        'label'   => 'Quote Position',
                                        'type'    => 'radio',
                                        'options' => [
                                            'left'   => 'Left',
                                            'center' => 'Center',
                                            'right'  => 'Right',
                                        ],
                                    ],
                                    'quote_content'  => [
                                        'span'  => 'auto',
                                        'label' => 'Details',
                                        'type'  => 'textarea',
                                    ],
                                ],
                            ],
                        ],
                        'span'   => 'full',
                        'tab'    => 'Content Blocks',
                    ],
                ], 'primary');
            });
        }
    }
}
