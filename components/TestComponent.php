<?php namespace October\Test\Components;

use Cms\Classes\ComponentBase;

class TestComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'TestComponent Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRender() {
        $this->page['demoProperty'] = $this->property('property');
    }
}
