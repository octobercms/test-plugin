<?php namespace October\Test\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Product Categories Backend Controller
 */
class ProductCategories extends Controller
{
    /**
     * @var array implement extensions
     */
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
     * @var array requiredPermissions to view this page
     */
    public $requiredPermissions = ['october.test.manage_products'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        // Product categories is a sub-page of Products, opened from the Products toolbar, so it keeps the Products menu item active
        BackendMenu::setContext('October.Test', 'test', 'products');
    }

    /**
     * onShowcaseAction answers the buttons and search input in the UI showcase with a flash message.
     */
    public function onShowcaseAction()
    {
        Flash::info(__("The showcase action ran."));
    }
}
