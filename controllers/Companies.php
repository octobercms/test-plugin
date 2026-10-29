<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Companies Backend Controller
 *
 * @link https://docs.octobercms.com/4.x/extend/system/controllers.html
 */
class Companies extends Controller
{
    /**
     * @var array implement extensions
     */
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
     * @var array requiredPermissions to view this page
     */
    public $requiredPermissions = ['october.test.manage_products'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        // Testing a plugin page linked into Tailor navigation, the product_companies extraNavigation item in blueprints/blog/blog.yaml
        BackendMenu::setTailorContext('Test\Blog', 'product_companies');
    }

    /**
     * listExtendQuery includes trashed records in the list.
     */
    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * formExtendQuery includes trashed records, so they can be opened and restored.
     */
    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }
}
