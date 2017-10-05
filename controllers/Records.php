<?php namespace October\Test\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Records extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [

    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('October.Test', 'test', 'records');
    }

}