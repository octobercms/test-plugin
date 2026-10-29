<?php namespace October\Test\ReportWidgets;

use Flash;
use Artisan;
use BackendAuth;
use ForbiddenException;
use Backend\Models\User as BackendUser;
use Dashboard\Classes\ReportWidgetBase;

/**
 * ClearCache is a dashboard report widget that tests Inspector properties (validation, dynamic dropdown and set options) and AJAX handlers with and without a form.
 *
 * @link https://docs.octobercms.com/4.x/extend/dashboards/report-widgets.html
 */
class ClearCache extends ReportWidgetBase
{
    /**
     * @var string defaultAlias to identify this widget
     */
    protected $defaultAlias = 'ClearCacheReportWidget';

    /**
     * defineProperties returns the Inspector properties for the widget.
     */
    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Clear Cache',
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
     * getUserOptions returns available backend users for the dropdown property.
     */
    public function getUserOptions()
    {
        return BackendUser::pluck('login', 'id')->all();
    }

    /**
     * getUsersOptions returns available backend users for the set property.
     */
    public function getUsersOptions()
    {
        return BackendUser::pluck('login', 'id')->all();
    }

    /**
     * render the widget
     */
    public function render()
    {
        return $this->makePartial('clearcache');
    }

    /**
     * onClearCache clears the application cache from a button outside a form, for users who can manage the settings.
     */
    public function onClearCache()
    {
        if (!BackendAuth::userHasAccess('october.test.manage_settings')) {
            throw new ForbiddenException;
        }

        Artisan::call('cache:clear');

        Flash::success('Cache cleared.');
    }

    /**
     * onTestAjax echoes the posted dashboard definition from a button inside a form to verify widget AJAX binding.
     */
    public function onTestAjax()
    {
        Flash::success('Widget AJAX handler reached.');

        return [
            '#'.$this->getId('testResult') => '_dash_definition: '.e(post('_dash_definition', '(missing)'))
        ];
    }
}
