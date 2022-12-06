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
            ],
            'sortColumn' => [
                'title' => 'Sort by Column',
                'description' => 'Model column the records should be ordered by',
                'type' => 'autocomplete',
                'group' => 'Sorting',
                'showExternalParam' => false
            ],
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
