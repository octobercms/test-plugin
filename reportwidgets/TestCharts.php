<?php namespace October\Test\ReportWidgets;

use Dashboard\Classes\ReportWidgetBase;

/**
 * TestCharts is a dashboard report widget that tests the pie, bar and line chart controls for initialization issues.
 *
 * @link https://docs.octobercms.com/4.x/extend/dashboards/report-widgets.html
 */
class TestCharts extends ReportWidgetBase
{
    /**
     * @var string defaultAlias to identify this widget
     */
    protected $defaultAlias = 'TestChartsReportWidget';

    /**
     * defineProperties returns the Inspector properties for the widget.
     */
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

    /**
     * render the widget
     */
    public function render()
    {
        return $this->makePartial('testcharts');
    }
}
