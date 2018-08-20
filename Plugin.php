<?php
namespace October\Test;

use Backend;
use Backend\Models\BrandSetting;
use Cms\Controllers\Themes;
use Cms\Models\ThemeData;
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
     * Extend Cms\Model\ThemeData
     */
    public function boot()
    {
        $availableColours = $this->getAvailableColors();
        Event::listen('backend.form.extendFields', function ($widget) use ($availableColours) {
            if ($widget->isNested) {
                return;
            }
            if (!$widget->getController() instanceof Themes) {
                return;
            }
            if (!$widget->model instanceof ThemeData) {
                return;
            }
            $widget->addFields([
                'test_colour'         => [
                    'label'           => 'Test Colour',
                    'required'        => 1,
                    'type'            => 'colorpicker',
                    'availableColors' => $availableColours,
                    'assetVar'        => 'testColour',
                    'span'            => 'left',
                    'tab'             => 'Global',
                ],
                'another_test_colour' => [
                    'label'           => 'Another Test Colour',
                    'required'        => 1,
                    'type'            => 'colorpicker',
                    'availableColors' => $availableColours,
                    'assetVar'        => 'anotherTestColour',
                    'span'            => 'right',
                    'tab'             => 'Global',
                ],
            ], 'primary');
        });
    }

    /**
     * Get Available Colors.
     *
     * @return array
     */
    protected function getAvailableColors()
    {
        $brand            = BrandSetting::instance();
        $availableColours = array_unique([
            BrandSetting::get('primary_color'),
            BrandSetting::get('secondary_color'),
            BrandSetting::get('accent_color'),
        ]);
        return $availableColours;
    }
}
