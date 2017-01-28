<?php namespace October\Test;

use App;
use Event;
use Backend;
use RainLab\Blog\Models\Post;
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
            'homepage'    => 'https://github.com/daftspunk/oc-test-plugin'
        ];
    }

    public function registerNavigation()
    {
        return [
            'test' => [
                'label'       => 'Playground',
                'url'         => Backend::url('october/test/people'),
                'icon'        => 'icon-child',
                'order'       => 100,

                'sideMenu' => [
                    'people' => [
                        'label'       => 'People',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/people'),
                    ],
                    'posts' => [
                        'label'       => 'Posts',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/posts'),
                    ],
                    'users' => [
                        'label'       => 'Users',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/users'),
                    ],
                    'countries' => [
                        'label'       => 'Countries',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/countries'),
                    ],
                    'reviews' => [
                        'label'       => 'Reviews',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/reviews'),
                    ],
                    'galleries' => [
                        'label'       => 'Galleries',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/galleries'),
                    ],
                    'trees' => [
                        'label'       => 'Trees',
                        'icon'        => 'icon-database',
                        'url'         => Backend::url('october/test/trees'),
                    ],
                ]
            ]
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'October\Test\FormWidgets\TimeChecker' => [
                'code'  => 'timecheckertest'
            ]
        ];
    }
    
    public function boot()
    {
        if (App::runningInBackend()) {
            
            Event::listen('backend.form.extendFields', function ($widget) {

                if (!$widget->getController() instanceof \RainLab\Blog\Controllers\Posts) {
                    return;
                }

                if (!$widget->model instanceof \RainLab\Blog\Models\Post) {
                    return;
                }
                
                if($widget->isNested) {
                    return;
                }
                
                $widget->model->jsonable = ['vimeo_videos'];
                
                $widget->addFields([
                    'vimeo_videos'  => [
                        'label'  => 'Vimeo Videos',
                        'prompt' => 'Add Vimeo Video',
                        'type'   => 'repeater',
                        'span'   => 'left',
                        'form'   => [
                            'fields' => [
                                'vimeo_id' => [
                                    'label'        => 'Vimeo ID',
                                    'placeholder'  => 'Enter Vimeo ID',
                                    'type'         => 'text'
                                ]
                            ]
                        ]  
                    ]
                ], 'primary');
            });
        }
    }
}
