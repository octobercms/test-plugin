<?php namespace October\Test\VueComponents;

use Dashboard\Classes\VueReportWidgetBase;
use Dashboard\Classes\ReportFetchData;
use Carbon\Carbon;

/**
 * MyCustomWidget is a Vue dashboard report widget that shows the server time, matching the Vue report widgets docs example.
 *
 * @link https://docs.octobercms.com/4.x/extend/dashboards/vue-report-widgets.html
 */
class MyCustomWidget extends VueReportWidgetBase
{
    /**
     * @var string componentName is the Vue component tag name.
     */
    protected $componentName = 'october-test-vuecomponents-mycustomwidget';

    /**
     * getData returns the current server time for the widget template.
     */
    public function getData(ReportFetchData $data): mixed
    {
        return [
            'current_time' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
