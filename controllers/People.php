<?php namespace October\Test\Controllers;

use BackendMenu;
use October\Test\Models\Phone;
use Backend\Classes\FormField;
use Backend\Classes\Controller;
use Backend\FormWidgets\DataTable;

/**
 * People Back-end Controller
 */
class People extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'people');
    }

    public function formExtendModel($model)
    {
        /*
         * Init proxy field model if we are creating the model
         * and the context is proxy fields.
         */
        if ($this->formGetContext() === 'proxyfields' && !$model->phone) {
            $model->phone = new Phone;
        }

        return $model;
    }

    public function onGetOptions()
    {
        $results = [
            'key' => 'value',
            'foo' => 'bar',
            'baz' => 'baz'
        ];

        return ['result' => $results];
    }

    public function onModelShowAddDatabaseColumnsPopup()
    {
        $config  = $this->makeConfig([
            'toolbar' => false,
            'columns' => [
                'type'   => [
                    'title'   => 'Widget Type',
                    'type'    => 'dropdown',
                    'options' => [
                        'petty' => 'Petty',
                        'minor' => 'Minor',
                        'major' => 'Major',
                        'critical' => 'Critical'
                    ],
                ],
            ],
        ]);

        $field = new FormField('add_database_columns', 'add_database_columns');
        $field->value = [
            ['a']
        ];

        $datatable = new DataTable($this, $field, $config);
        $datatable->alias = 'add_database_columns_datatable';
        $datatable->bindToController();

        return $this->makePartial('datatable', [
            'datatable' => $datatable,
        ]);
    }
}
