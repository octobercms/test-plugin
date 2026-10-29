<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Products Backend Controller
 */
class Products extends Controller
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

        BackendMenu::setContext('October.Test', 'test', 'products');
    }

    /**
     * formExtendFields adds a field to the product form only, since relation and pivot forms do not call it.
     */
    public function formExtendFields($form)
    {
        $form->addFields([
            'extended_note' => ['label' => 'Extended Note'],
        ]);
    }

    /**
     * formBeforeSave uppercases the title, testing formSetSaveValue.
     */
    public function formBeforeSave($model)
    {
        $this->formSetSaveValue('title', strtoupper((string) post('Product[title]')));
    }
}
