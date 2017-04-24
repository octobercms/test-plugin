<?php

namespace October\Test\ReportWidgets;

use Backend\Classes\ReportWidgetBase;

class SolidGauge extends ReportWidgetBase
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'solidGauge';

    public function render()
    {
        $this->vars['id'] = rand();
        return $this->makePartial('widget');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'Title',
                'default'           => 'Visitor Traffic',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'legend' => [
                'title'             => 'Legend',
                'default'           => 'Visitors',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The chart legend is required.'
            ],
            'days' => [
                'title'             => 'Number of days to display data for',
                'default'           => '16',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$'
            ]
        ];
    }

    public function loadAssets()
    {
        $this->addJs('js/highcharts.js');
        $this->addJs('js/highcharts-more.js');
        $this->addJs('js/solid-gauge.js');
    }
}