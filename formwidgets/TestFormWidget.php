<?php namespace October\Test\FormWidgets;

use Str;
use Input;
use Request;
use Response;
use Validator;
use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use ApplicationException;
use ValidationException;
use Exception;

class TestFormWidget extends FormWidgetBase
{
    use \Backend\Traits\FormModelWidget;

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'testformwidget';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->fillFromConfig([
            
        ]);
    }
    

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->vars['testImg'] = 'http://placehold.it/50x50';
        return $this->makePartial('testformwidget');
    }
    
    /**
     * Test AJAX
     */
    public function onUpdateImage()
    {
        $this->vars['testImg'] = 'http://placehold.it/300x300';
        return $this->makePartial('testformwidget');
    }
    
    public function onUpdateImageCorrectly()
    {
        $this->vars['testImg'] = 'http://placehold.it/300x300';
        return ['#testimg-result-2' => $this->makePartial('testimg')];
    }
}
