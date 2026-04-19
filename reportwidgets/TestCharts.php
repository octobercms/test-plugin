<?php namespace October\Test\ReportWidgets;

use Dashboard\Classes\ReportWidgetBase;
use Exception;

/**
 * TestCharts Report Widget
 *
 * Tests chart controls (pie, bar, line) for initialization issues.
 */
class TestCharts extends ReportWidgetBase
{
    protected $defaultAlias = 'TestChartsReportWidget';

    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Test Charts',
                'type' => 'string',
                'validation' => [
                    'required' => [
                        'message' => 'The Widget Title is required.'
                    ],
                ]
            ],
        ];
    }

    public function render()
    {
        try {
            $this->prepareVars();
        }
        catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('testcharts');
    }

    public function prepareVars()
    {
    }

    protected function loadAssets()
    {
    }
}