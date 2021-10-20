<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Depends Backend Controller
 */
class Depends extends Controller
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

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'depends');
    }

    public function formExtendRefreshData($host, $saveData)
    {
        
        $saveData['slave_text'] =  $saveData['master'];
        $saveData['slave_widget'] =  $saveData['master'];

        $repiter = [];
        for($i=0; $i<10; $i++){
            $repiter[] = [
                'first_field' => $saveData['master'],
                'second_field' => $saveData['master'],
            ];
        }

        $saveData['slave_repiter'] =  $repiter;

        return $saveData;
    }
}
