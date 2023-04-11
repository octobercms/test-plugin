<?php namespace October\Test\Components;

use Flash;
use Cms\Classes\ComponentBase;

/**
 * KitchenSink
 */
class KitchenSink extends ComponentBase
{
    /**
     * @var bool isSubmitted
     */
    public $isSubmitted = false;

    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Kitchen Sink',
            'description' => 'Who left this here?'
        ];
    }

    /**
     * defineProperties
     */
    public function defineProperties()
    {
        return [
            // https://docs.octobercms.com/3.x/element/inspector/type-dropdown.html
            'type' => [
                'title' => 'Entity Type',
                'type' => 'dropdown',
                'showExternalParam' => false
            ],
            'handle' => [
                'title' => 'Entity Handle',
                'type' => 'dropdown',
                'depends' => ['type'],
                'showExternalParam' => false
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-string.html
            'slug' => [
                'title' => 'Slug',
                'type' => 'string',
                'description' => 'Specify a slug to make this a primary page for the record.'
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-checkbox.html
            'defaultView' => [
                'title' => 'Default View',
                'type' => 'checkbox',
                'default' => 1,
                'description' => 'Used as default entry point when previewing the record.',
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-autocomplete.html
            'sortColumn' => [
                'title' => 'Sort by Column',
                'description' => 'Model column the records should be ordered by',
                'type' => 'autocomplete',
                'showExternalParam' => false
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-set.html
            'units' => [
                'title' => 'Select Muitple Units',
                'description' => 'Hello',
                'type' => 'set',
                'items' => [
                    'metric' => 'Metric',
                    'imperial' => 'Imperial'
                ]
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-dictionary.html
            'options' => [
                'title' => 'Options',
                'type' => 'dictionary',
                'default' => ['option1' => 'Option 1'],
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-object.html
            'address' => [
                'title' => 'Address',
                'type' => 'object',
                'properties' => [
                    'streetAddress' => [
                        'title' => 'Street Address',
                        'type' => 'string'
                    ],
                    'city' => [
                        'title' => 'City',
                        'type' => 'string'
                    ],
                    'country' => [
                        'title' => 'Country',
                        'type' => 'dropdown',
                        'options' => [
                            'us' => 'US',
                            'ca' => 'Canada'
                        ]
                    ]
                ],
            ],

            // https://docs.octobercms.com/3.x/element/inspector/type-objectlist.html
            'addressList' => [
                'title' => 'Address (List)',
                'type' => 'objectList',
                'titleProperty' => 'fullName',
                'itemProperties' => [
                    'fullName' => [
                        'title' => 'Full Name',
                        'type' => 'string'
                    ],
                    'address' => [
                        'title' => 'Address',
                        'type' => 'string'
                    ]
                ]
            ]
        ];
    }

    /**
     * onTestAjax
     */
    public function onTestAjax()
    {
        Flash::success('This came from the kitchen sink!');
        $this->isSubmitted = true;
    }

    /**
     * getSortColumnOptions
     */
    public function getSortColumnOptions()
    {
        return [
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete',
        ];
    }

    /**
     * getEntityTypeOptions
     */
    public function getEntityTypeOptions()
    {
        return [
            'entry' => 'Entry',
            'collection' => 'Collection',
        ];
    }

    /**
     * getEntityHandleOptions
     */
    public function getEntityHandleOptions()
    {
        $type = $this->property('type');

        if ($type === 'collection') {
            $result = [
                'paradise' => 'Paradise',
                'nirvana' => 'Nirvana',
            ];
        }
        else {
            $result = [
                'boring' => 'Boring',
                'kirby' => 'Kirby',
            ];
        }

        return $result;
    }

    /**
     * getFoo
     */
    public function getFoo()
    {
        return 'bar';
    }

    /**
     * getTestUser
     */
    public function getTestUser()
    {
        return \October\Test\Models\User::first();
    }

    /**
     * onFilterCars
     */
    public function onFilterCars()
    {
        Flash::success('This came from a component');
    }
}
