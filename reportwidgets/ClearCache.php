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
            'name' => [
                'title' => 'Name',
                'default' => 'Clear Cache Report Widget',
                'type' => 'string',
                'validation' => [
                    'required' => [
                        'message' => 'The Name field is required'
                    ],
                    'regex' => [
                        'message' => 'The Name field can contain only Latin letters.',
                        'pattern' => '^[a-zA-Z]+$'
                    ]
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
