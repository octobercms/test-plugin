<?php namespace October\Test\Components;

use Cms\Classes\ComponentBase;

/**
 * KitchenSink
 */
class KitchenSink extends ComponentBase
{
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
            'slug' => [
                'title' => 'Slug',
                'type' => 'string',
                'description' => 'Specify a slug to make this a primary page for the record.'
            ],
            'defaultView' => [
                'title' => 'Default View',
                'type' => 'checkbox',
                'default' => 1,
                'description' => 'Used as default entry point when previewing the record.',
            ]
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
}
