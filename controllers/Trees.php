<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Trees Backend Controller
 */
class Trees extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var array listConfig files, one for each list on the index page
     */
    public $listConfig = [
        'members' => 'config_members_list.yaml',
        'categories' => 'config_categories_list.yaml',
        'channels' => 'config_channels_list.yaml',
        'trashed_channels' => 'config_trashed_channels_list.yaml'
    ];

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

        BackendMenu::setContext('October.Test', 'test', 'trees');
    }

    /**
     * index renders the tree lists and the trashed channels list on one page under a shared title.
     */
    public function index()
    {
        $this->asExtension('ListController')->index();

        $this->pageTitle = __("Trees");
    }

    /**
     * listExtendQuery limits the trashed channels list to soft deleted channels, so they can be opened and restored.
     */
    public function listExtendQuery($query, $definition = null)
    {
        if ($definition === 'trashed_channels') {
            $query->onlyTrashed();
        }
    }
}
