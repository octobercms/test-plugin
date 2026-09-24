<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\FormWidgets\DataTable;

/**
 * Orders Backend Controller
 */
class Orders extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
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
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'products');
    }

    public function onModelShowAddDatabaseColumnsPopup()
    {
        $config  = $this->makeConfig([
            'toolbar' => false,
            'columns' => [
                'type' => [
                    'title' => 'Widget Type',
                    'type' => 'dropdown',
                    'options' => [
                        'petty' => 'Petty',
                        'minor' => 'Minor',
                        'major' => 'Major',
                        'critical' => 'Critical'
                    ],
                ],
            ],
        ]);

        $datatable = $this->makeFormWidget(DataTable::class, 'add_database_columns', $config);
        $datatable->alias = 'add_database_columns_datatable';
        $datatable->bindToController();

        return $this->makePartial('datatable', [
            'datatable' => $datatable,
        ]);
    }
}
