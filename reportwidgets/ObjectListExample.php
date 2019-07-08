<?php namespace October\Test\ReportWidgets;

use Flash;
use Event;
use Exception;
use Backend\Classes\ReportWidgetBase;

class ObjectListExample extends ReportWidgetBase
{
    public function init()
    {
    }

    public function render()
    {
        return $this->makePartial('test');
    }
  
    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'Widget title',
                'default'           => 'Query',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'filter' => [
                'title'             => 'Where',
                'type'              => 'objectList',
                'titleProperty'     => 'column',
                'itemProperties'    => [
                    [
                        'property'  => 'column',
                        'title'     => 'Column',
                        'type'      => 'string',
                    ],
                    [
                        'property'  => 'type',
                        'title'     => 'Type',
                        'type'      => 'dropdown',
                        'default'   => '=',
                        'options'   => [
                            '='     => '=',
                            '!='    => '!=',
                            'null' => 'is null',
                            'notNull' => 'is not null',
                        ],
                    ],
                    [
                        'property'  => 'value',
                        'title'     => 'Value',
                        'type'      => 'string',
                    ],
                ],
            ],
        ];
    }
}
