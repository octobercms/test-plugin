<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Trees Back-end Controller
 */
class Trees extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController'
    ];

    public $listConfig = [
        'members' => 'config_members_list.yaml',
        'categories' => 'config_categories_list.yaml',
        'channels' => 'config_channels_list.yaml',
        'relations' => 'config_relations_list.yaml',
        'relationsTree' => 'config_relationsTree_list.yaml',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'trees');
    }
}