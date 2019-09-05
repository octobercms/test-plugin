<?php namespace October\Test\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Backend\Classes\FormField;
use Config;

class CheckboxList extends FormWidgetBase
{

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'checkboxlist';    

    /**
     * Widget Details
     */
    public function widgetDetails()
    {
        return [
            'name' => 'Checkbox list (hard-coded) example',
            'description' => 'This widget tests a hardcoded version of the checkbox list'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return $this->makePartial('checkboxlist');
    }

    /**
    * Process the postback data for this widget.
    * @param $value The existing value for this widget.
    * @return string The new value for this widget.
    */
    public function getSaveValue($value)
    {      
        return ($value);
    }

}
