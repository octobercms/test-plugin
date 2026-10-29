<?php namespace October\Test\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Pages Backend Controller
 */
class Pages extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
        \Backend\Behaviors\ImportExportController::class
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
     * @var string importExportConfig file
     */
    public $importExportConfig = 'config_import_export.yaml';

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

        BackendMenu::setContext('October.Test', 'test', 'pages');
    }

    /**
     * update sets a compact body class, as part of testing the classic form with sidebar layout in update.php.
     */
    public function update(...$args)
    {
        $this->bodyClass = 'compact-container';

        return $this->asExtension('FormController')->update(...$args);
    }

    /**
     * onTestChangeHandler flashes a message when a person is picked, testing a changeHandler on the recordfinder inside the people repeater.
     */
    public function onTestChangeHandler()
    {
        Flash::info(__("A person was picked in the People repeater."));
    }
}
