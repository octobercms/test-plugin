<?php namespace October\Test\Components;

use Cms\Classes\ComponentBase;

/**
 * VueTester smoke tests Vue component registration on the frontend.
 */
class VueTester extends ComponentBase
{
    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Vue Tester',
            'description' => 'Smoke tests Vue components on the frontend.'
        ];
    }

    /**
     * init registers Vue components for page renders and AJAX requests.
     */
    public function init()
    {
        $this->registerVueComponent(\October\Test\VueComponents\TallyCounter::class);
    }

    /**
     * onLoadPanel registers a Vue component only during an AJAX request.
     */
    public function onLoadPanel()
    {
        $this->registerVueComponent(\October\Test\VueComponents\LazyPanel::class);
    }
}
