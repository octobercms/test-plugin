<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Users Back-end Controller
 */
class Users extends Controller
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

        BackendMenu::setContext('October.Test', 'test', 'users');
    }

    public function listFilterExtendScopes($filter)
    {
        // Demonstrate how to disable a scope based on the value of another scope
        if (input('scopeName') === 'disable_roles') {
            $disableRoles = input('value');
            if ($disableRoles === 'false') {
                $disableRoles = false;
            }
        } else {
            $disableRoles = $filter->getScopeValue('disable_roles');
        }

        if ($disableRoles) {
            $filter->removeScope('roles');
        }

        $filter->bindEvent('filter.update', function ($params) use ($filter) {
            $filter->prepareVars();
            return [
                '#' . $filter->getId() => $filter->makePartial('filter_scopes'),
            ];
        });
    }
}
