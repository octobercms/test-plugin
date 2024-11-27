<?php namespace October\Test\Controllers;

use Event;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Products Backend Controller
 */
class Products extends Controller
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

        // Adds a field to the primary model but not when used as a pivot form
        Event::listen('backend.form.extendFields', function ($widget) {
            if (
                !$widget->getController() instanceof \October\Test\Controllers\Products ||
                !$widget->getModel() instanceof \October\Test\Models\Product ||
                $widget->getContext() === 'pivot'
            ) {
                return;
            }

            $widget->addField('garbage', [
                'label' => 'Garbage Field'
            ]);
        });
    }

    /**
     * formBeforeSave
     */
    public function formBeforeSave($model)
    {
        $this->formSetSaveValue('title', strtoupper(post('Product[title]')));
    }
}
