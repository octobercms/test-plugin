<?php namespace October\Test\Classes;

use October\Test\Models\Page;

/**
 * ExtendCoreFeatures uses the extension points a plugin has for models and backend pages.
 */
class ExtendCoreFeatures
{
    /**
     * subscribe registers the event listeners and model extensions.
     */
    public function subscribe($events)
    {
        $this->extendPageModel();

        $events->listen('backend.page.beforeDisplay', [static::class, 'addCustomButtonScript']);
    }

    /**
     * extendPageModel makes parent_id translatable, testing a model extended from outside its class.
     */
    public function extendPageModel()
    {
        Page::extend(function ($model) {
            $model->translatable = array_merge($model->translatable, ['parent_id']);
        });
    }

    /**
     * addCustomButtonScript loads the rich editor custom button script on every backend page.
     */
    public function addCustomButtonScript($controller)
    {
        $controller->addJs('/plugins/october/test/assets/js/custom-button.js');
    }
}
