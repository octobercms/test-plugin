<?php namespace October\Test\Components;

use Flash;
use Cms\Classes\ComponentBase;

/**
 * KitchenSink is a CMS component and page snippet that tests the Inspector property types, dependent dropdown options, snippet AJAX, getter methods read from Twig and component AJAX handlers.
 */
class KitchenSink extends ComponentBase
{
    /**
     * @var bool isSubmitted is set by onTestAjax so the theme can show a thank you message
     */
    public $isSubmitted = false;

    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Kitchen Sink',
            'description' => 'Tests the Inspector property types and other component features.',
            'snippetAjax' => true
        ];
    }

    /**
     * defineProperties
     */
    public function defineProperties()
    {
        return [
            // https://docs.octobercms.com/4.x/element/inspector/type-dropdown.html
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

            // https://docs.octobercms.com/4.x/element/inspector/type-string.html
            'slug' => [
                'title' => 'Slug',
                'type' => 'string',
                'description' => 'Specify a slug to make this a primary page for the record.'
            ],

            // https://docs.octobercms.com/4.x/element/inspector/type-checkbox.html
            'defaultView' => [
                'title' => 'Default View',
                'type' => 'checkbox',
                'default' => 1,
                'description' => 'Used as default entry point when previewing the record.',
            ],

            // https://docs.octobercms.com/4.x/element/inspector/type-autocomplete.html
            'sortColumn' => [
                'title' => 'Sort by Column',
                'description' => 'Model column the records should be ordered by',
                'type' => 'autocomplete',
                'showExternalParam' => false
            ],

            // https://docs.octobercms.com/4.x/element/inspector/type-set.html
            'units' => [
                'title' => 'Select Multiple Units',
                'description' => 'Units of measurement to display.',
                'type' => 'set',
                'items' => [
                    'metric' => 'Metric',
                    'imperial' => 'Imperial'
                ]
            ],

            // https://docs.octobercms.com/4.x/element/inspector/type-dictionary.html
            'options' => [
                'title' => 'Options',
                'type' => 'dictionary',
                'default' => ['option1' => 'Option 1'],
            ],

            // https://docs.octobercms.com/4.x/element/inspector/type-object.html
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

            // https://docs.octobercms.com/4.x/element/inspector/type-objectlist.html
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
     * onTestAjax handles the theme contact form and flags it as submitted.
     */
    public function onTestAjax()
    {
        Flash::success('This came from the kitchen sink!');
        $this->isSubmitted = true;
    }

    /**
     * getSortColumnOptions returns the options for the sortColumn autocomplete.
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
     * getTypeOptions returns the options for the type dropdown.
     */
    public function getTypeOptions()
    {
        return [
            'entry' => 'Entry',
            'collection' => 'Collection',
        ];
    }

    /**
     * getHandleOptions returns options that depend on the selected type, testing the Inspector depends option.
     */
    public function getHandleOptions()
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
     * getFoo returns a fixed value, testing that Twig resolves kSink.foo to this getter.
     */
    public function getFoo()
    {
        return 'bar';
    }

    /**
     * getTestUser returns the first user, testing that Twig resolves kSink.testUser to this getter and reads the model.
     */
    public function getTestUser()
    {
        return \October\Test\Models\User::first();
    }

    /**
     * onFilterCars shares its name with a page handler, testing that the component handler runs when called by alias.
     */
    public function onFilterCars()
    {
        Flash::success('This came from a component');
    }
}
