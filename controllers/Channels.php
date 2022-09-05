<?php namespace October\Test\Controllers;

use Lang;
use Flash;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Channels Back-end Controller
 */
class Channels extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ReorderController::class
    ];

    public $formConfig = 'config_form.yaml';

    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'trees');
    }

    /**
     * formExtendQuery
     */
    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * update_onRestore handles restoring users
     */
    public function update_onRestore($recordId)
    {
        $this->formFindModelObject($recordId)->restore();

        Flash::success(Lang::get('backend::lang.form.restore_success', ['name' => Lang::get('backend::lang.user.name')]));

        return Redirect::refresh();
    }
}
