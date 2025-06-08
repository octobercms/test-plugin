<?php namespace October\Test\VueComponents;

use Dashboard\Classes\VueReportWidgetBase;
use Dashboard\Classes\ReportFetchData;
use Carbon\Carbon;

class MyCustomWidget extends VueReportWidgetBase
{
    public function getData(ReportFetchData $data): mixed
    {
        return [
            'current_time' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
