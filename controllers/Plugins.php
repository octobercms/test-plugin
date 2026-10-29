<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Test\Models\Meta;

/**
 * Plugins Backend Controller is reached from the Manage Plugins button on the Reviews toolbar.
 */
class Plugins extends Controller
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

        BackendMenu::setContext('October.Test', 'test', 'reviews');
    }

    /**
     * formExtendFields adds the meta fields to a Meta tab, testing fields that save to a related model, where a nestedform field with defaultCreate is the declarative alternative to these meta hooks.
     */
    public function formExtendFields($form)
    {
        $config = $this->makeConfig('$/october/test/models/meta/fields.yaml');

        foreach ($config->fields as $field => $options) {
            $form->addTabFields([
                'meta['.$field.']' => $options + ['tab' => 'Meta']
            ]);
        }
    }

    /**
     * formExtendModel creates the related meta model when the plugin has none yet.
     */
    public function formExtendModel($model)
    {
        if (!$model->meta) {
            $model->meta = new Meta;
        }

        return $model;
    }
}
