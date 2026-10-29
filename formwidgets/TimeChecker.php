<?php namespace October\Test\FormWidgets;

use Backend;
use Carbon\Carbon;
use Backend\Classes\FormWidgetBase;

/**
 * TimeChecker is a form widget that updates its own partials and the controller partials using AJAX handlers.
 */
class TimeChecker extends FormWidgetBase
{
    /**
     * @var string defaultAlias to identify this widget
     */
    protected $defaultAlias = 'timechecker';

    /**
     * render the widget
     */
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('timechecker');
    }

    /**
     * prepareVars for the widget partials
     */
    protected function prepareVars()
    {
        $randomDate = Carbon::now()->addMinutes(rand(1, 60));

        $size = in_array(post('size'), ['50x50', '300x300'], true) ? post('size') : '50x50';

        $this->vars['testImg'] = 'https://picsum.photos/'.str_replace('x', '/', $size);
        $this->vars['currentTime'] = Backend::dateTime($randomDate);
    }

    /**
     * onPullImage prepares the image URL, the request names the widget or controller partial that displays it.
     */
    public function onPullImage()
    {
        $this->prepareVars();

        return $this->makePartial('timechecker');
    }

    /**
     * onPushUpdateTime pushes a new random time to the container element.
     */
    public function onPushUpdateTime()
    {
        $this->prepareVars();

        return ['#'.$this->getId('container') => $this->makePartial('current_time')];
    }
}
