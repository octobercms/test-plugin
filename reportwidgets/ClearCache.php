<?php namespace October\Test\ReportWidgets;

use Backend\Models\User as BackendUser;
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
            ],
            'user' => [
                'title' => 'User',
                'type' => 'dropdown',
            ],
            'users' => [
                'title' => 'Users',
                'type' => 'set',
            ],
        ];
    }

    /**
     * getUserOptions returns available backend users for the dropdown property
     */
    public function getUserOptions()
    {
        return BackendUser::pluck('login', 'id')->all();
    }

    /**
     * getUsersOptions returns available backend users for the set property
     */
    public function getUsersOptions()
    {
        return BackendUser::pluck('login', 'id')->all();
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
