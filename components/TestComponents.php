<?php namespace October\Test\Components;

use Cms\Classes\ComponentBase;

class TestComponents extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'TestComponents Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function test()
    {
        // this code will not work either

        // echo 'this text should appear';
        // die();

        dd('If a new version of twig (≥ 2.10.0) is installed, it will give out 500 error');
    }
}
