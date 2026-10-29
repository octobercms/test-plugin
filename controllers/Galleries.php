<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Galleries Backend Controller
 */
class Galleries extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
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

        BackendMenu::setContext('October.Test', 'test', 'galleries');
    }

    /**
     * formExtendFields makes the posts field read only, testing a field changed at runtime.
     */
    public function formExtendFields($form)
    {
        if ($posts = $form->getField('posts')) {
            $posts->readOnly = true;
        }
    }
}
