<?php namespace October\Test\Controllers;

use Input;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Countries Back-end Controller
 */
class Countries extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'countries');
    }

    public function onGetDangerComputedValue()
    {
        $rowData = Input::get('rowData');
        $dangerScore = 0;

        switch ($rowData['type']) {
            default:
                $dangerScore += 1;
                break;
            case 'Minor':
                $dangerScore += 5;
                break;
            case 'Major':
                $dangerScore += 10;
                break;
            case 'Capital':
                $dangerScore += 20;
                break;
        }

        if (is_numeric($rowData['rating'])) {
            $dangerScore += (int) $rowData['rating'];
        }

        if ($dangerScore >= 30) {
            return 'Extremely Dangerous';
        } else if ($dangerScore >= 20) {
            return 'Dangerous';
        } else if ($dangerScore >= 15) {
            return 'Maintain Caution';
        } else if ($dangerScore >= 10) {
            return 'Keep Alert';
        } else if ($dangerScore >= 5) {
            return 'Low Risk';
        } else {
            return 'No Risk';
        }
    }
}
