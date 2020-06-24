<?php namespace October\Test\Controllers;

use Request;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Countries Back-end Controller
 */
class Countries extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'countries');
    }

    public function formExtendFields($form)
    {
        if (!$form->isNested && $form->model instanceof \October\Test\Models\Country) {
            $isActive = false;
            if (Request::ajax()) {
                $isActive = input('Country[is_active]', false);
            } elseif ($form->model->exists) {
                $isActive = $form->model->is_active;
            }

            if ($isActive) {
                $form->addFields([
                    'dynamic_flags' => [
                        'label' => 'Active Flags (Dynamic Fileupload Field)',
                        'type' => 'fileupload',
                        'mode' => 'image',
                        'span' => 'right',
                    ],
                ]);
            }
        }
    }
}
