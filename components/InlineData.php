<?php namespace October\Test\Components;

use Cms\Classes\ComponentBase;

/**
 * InlineData is a snippet that renders inline within page content.
 */
class InlineData extends ComponentBase
{
    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Inline Data',
            'description' => 'Displays a piece of data inline within the content.',
            'snippetInline' => true
        ];
    }

    /**
     * defineProperties
     */
    public function defineProperties()
    {
        return [
            'type' => [
                'title' => 'Data',
                'type' => 'dropdown',
                'default' => 'phone',
                'showExternalParam' => false
            ]
        ];
    }

    /**
     * getTypeOptions
     */
    public function getTypeOptions()
    {
        return [
            'phone' => 'Phone number',
            'email' => 'Email address',
            'address' => 'Address'
        ];
    }

    /**
     * getData returns the value for the selected data type.
     */
    public function getData()
    {
        return match ($this->property('type')) {
            'email' => 'hello@example.com',
            'address' => '123 Example Street',
            default => '+1 (555) 000-0000'
        };
    }
}
