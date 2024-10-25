<?php namespace October\Test\VueComponents;

use Backend\Classes\VueReportWidgetBase;
use Carbon\Carbon;

class MyCustomWidget extends VueReportWidgetBase
{
    public function getData(
        array $widgetConfig,
        ?Carbon $dateStart,
        ?Carbon $dateEnd,
        ?int $startTimestamp,
        ?Carbon $compareDateStart,
        ?Carbon $compareDateEnd,
        ?string $aggregationInterval,
        array $extraData
    ): mixed {
        return [
            'current_time' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
