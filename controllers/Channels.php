<?php namespace October\Test\Controllers;

use Flash;
use Redirect;
use BackendMenu;
use ForbiddenException;
use Backend\Classes\Controller;

/**
 * Channels Backend Controller has no list of its own and is reached from the channel lists on the Trees page.
 */
class Channels extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

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
     * formExtendQuery includes trashed records, so they can be opened and restored.
     */
    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * update_onRestore restores a trashed channel from its update page, guarded by the same permission as delete.
     */
    public function update_onRestore($recordId)
    {
        if (!$this->formCheckPermission('modelDelete')) {
            throw new ForbiddenException;
        }

        $this->formFindModelObject($recordId)->restore();

        Flash::success(__(":name Restored", ['name' => __("Channel")]));

        return Redirect::refresh();
    }
}
