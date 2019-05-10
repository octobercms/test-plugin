<?php

namespace October\Test;

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
                    'pages'     => [
                        'label' => 'Pages',
                        'icon'  => 'icon-database',
                        'url'   => Backend::url('october/test/pages'),
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

    public function boot()
    {
        if (\App::runningInBackend()) {
            $pluginManager = \System\Classes\PluginManager::instance();
            if ($pluginManager->hasPlugin('RainLab.Pages')) {
                \Event::listen('backend.form.extendFields', function ($widget) {
                    if ($widget->isNested || $widget->model->url !== '/') {
                        return;
                    }
                    if ($widget->model instanceof \RainLab\Pages\Classes\Page) {
                        $widget->addFields([
                            'viewBag[test_repeater]' => [
                                'prompt' => 'Add Data',
                                'type'   => 'repeater',
                                'groups' => [
                                    'textarea' => [
                                        'name'        => 'Textarea',
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
                                    'image'    => [
                                        'name'        => 'Image',
                                        'description' => 'Pick something from the media library',
                                        'icon'        => 'icon-photo',
                                        'fields'      => [
                                            'img_upload'   => [
                                                'span'        => 'auto',
                                                'label'       => 'Image',
                                                'type'        => 'mediafinder',
                                                'mode'        => 'image',
                                                'imageHeight' => 260,
                                                'imageWidth'  => 260,
                                            ],
                                            'img_position' => [
                                                'span'    => 'auto',
                                                'label'   => 'Image Position',
                                                'type'    => 'radio',
                                                'options' => [
                                                    'left'   => 'Left',
                                                    'center' => 'Center',
                                                    'right'  => 'Right',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'span'   => 'full',
                                'tab'    => 'Test',
                            ],
                        ], 'primary');
                        $this->bindRepeaterValidationRules($widget->model);
                    }
                });
            }
        }
    }
    
    protected function bindRepeaterValidationRules($model)
    {
        $model->rules += [
            'test_repeater' => 'required',
        ];
        $model->customMessages += [
            'blocks.required_if' => 'The content blocks field is required',
        ];
        $model->bindEvent('model.beforeValidate', function () use ($model) {
            if (!empty($model->test_repeater)) {
                foreach ($model->test_repeater as $index => $repeater) {
                    $repeaterGroup       = $repeater['_group'];
                    $repeaterGroupPrefix = 'test_repeater.' . $index . '.'; // <-- Repeater Group $index referenced here
                    switch ($repeaterGroup) {
                        case 'textarea':
                            $model->rules[$repeaterGroupPrefix . 'text_area']                   = 'required';
                            $model->customMessages[$repeaterGroupPrefix . 'text_area.required'] = 'Please enter text area';
                            break;
                        case 'quote':
                            $model->rules[$repeaterGroupPrefix . 'quote_position']                   = 'required';
                            $model->rules[$repeaterGroupPrefix . 'quote_content']                    = 'required';
                            $model->customMessages[$repeaterGroupPrefix . 'quote_position.required'] = 'Please select quote position';
                            $model->customMessages[$repeaterGroupPrefix . 'quote_content.required']  = 'Please enter quote content';
                            break;
                        case 'image':
                            $model->rules[$repeaterGroupPrefix . 'img_upload']                     = 'required';
                            $model->rules[$repeaterGroupPrefix . 'img_position']                   = 'required';
                            $model->customMessages[$repeaterGroupPrefix . 'img_upload.required']   = 'Please upload image';
                            $model->customMessages[$repeaterGroupPrefix . 'img_position.required'] = 'Please select image position';
                            break;
                    }
                }
            }
        });
    }
}
