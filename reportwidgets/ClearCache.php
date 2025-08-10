<?php namespace October\Test\ReportWidgets;

use Dashboard\Classes\ReportWidgetBase;
use Exception;
use Artisan;
use Flash;

/**
 * ClearCache Report Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/backend/report-widgets.html
 */
class ClearCache extends ReportWidgetBase
{
    protected $defaultAlias = 'ClearCacheReportWidget';

    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Top Pages',
                'type' => 'string',
                'validation' => [
                    'required' => [
                        'message' => 'The Widget Title is required.'
                    ],
                ]
            ],
            'days' => [
                'title' => 'Number of days to display data for',
                'default' => '7',
                'type' => 'string',
                'validation' => [
                    'regex' => [
                        'message' => 'The days property can contain only numeric symbols.',
                        'pattern' => '^[0-9]+$'
                    ]
                ]
            ]
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

        return $this->makePartial('clearcache');
    }

    public function prepareVars()
    {
    }

    protected function loadAssets()
    {
    }

    public function onClearCache()
    {
        Artisan::call('cache:clear');
        Flash::success('Cache cleared.');
    }
}
