<?php namespace October\Test\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Users Backend Controller
 */
class Users extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string relationConfig file
     */
    public $relationConfig = 'config_relation.yaml';

    /**
     * @var array requiredPermissions to view this page
     */
    public $requiredPermissions = ['october.test.access_plugin'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'users');
    }

    /**
     * beforeDisplay adds the control that converts the username field to uppercase.
     */
    public function beforeDisplay()
    {
        $this->addJs('/plugins/october/test/assets/js/uppercase-input.js');
    }

    /**
     * relationExtendManageListWidget only offers roles with "test" in their name when linking roles.
     */
    public function relationExtendManageListWidget($widget, $field, $model)
    {
        if ($field === 'roles') {
            $widget->bindEvent('list.extendQuery', function ($query) {
                $query->where('name', 'like', '%test%');
            });
        }
    }

    /**
     * onSelectPeriod flashes the period picked in the list toolbar.
     */
    public function onSelectPeriod()
    {
        Flash::success('Selected period: ' . post('period'));
    }

    /**
     * onGetSelectOptions returns the options for the AJAX select in the list toolbar.
     */
    public function onGetSelectOptions()
    {
        return [
            'results' => [
                'w25' => 'Width 25',
                'h40' => 'Height 40',
                'p90' => 'Padding 90',
            ]
        ];
    }
}
