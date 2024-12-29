<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Companies Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class Companies extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
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
     * @var array required permissions
     */
    public $requiredPermissions = ['october.test.companies'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        // BackendMenu::setContext('October.Test', 'test', 'products');
        BackendMenu::setTailorContext('Test\Blog', 'product_companies');
    }

    /**
     * listExtendQuery
     */
    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * formExtendQuery
     */
    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }
}
