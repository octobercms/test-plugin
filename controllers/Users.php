<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;

/**
 * Users Back-end Controller
 */
class Users extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'users');
    }

    public function onSelectPeriod()
    {
        Flash::success('Selected priod: '.post('period'));
    }

    public function onGetSelectOptions()
    {
        return [
            'results' => [
                'w25' => 'Width 25',
                'h40' => 'Height 40',
                'p90' => 'Padding 40',
            ]
        ];
    }
}
