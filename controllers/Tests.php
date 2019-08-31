<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Various Tests Controller
 */
class Tests extends Controller
{
    public $implement = ['Backend.Behaviors.FormController'];

    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'tests');
    }
}
