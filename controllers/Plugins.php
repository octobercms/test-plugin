<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Test\Models\Meta;

/**
 * Plugins Back-end Controller
 */
class Plugins extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'reviews');
    }

    public function formExtendFields($form)
    {
        $config = $this->makeConfig('$/october/test/models/meta/fields.yaml');

        foreach ($config->fields as $field => $options) {
            $form->addTabFields([
                'meta['.$field.']' => $options + ['tab' => 'Meta']
            ]);
        }
    }

    public function formExtendModel($model)
    {
        if (!$model->meta) {
            $model->meta = new Meta;
        }

        return $model;
    }
}
