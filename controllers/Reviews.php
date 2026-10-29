<?php namespace October\Test\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Reviews Backend Controller
 */
class Reviews extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
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
     * onChangeContent refreshes dependent fields when the content changes, testing a change handler that returns field updates.
     */
    public function onChangeContent()
    {
        Flash::success('Great job!');

        return $this->formRefreshFields(['_internal_comments', 'is_positive']);
    }

    /**
     * onChangeReviewDate writes the posted form data to the trace log, testing a change handler on a date field.
     */
    public function onChangeReviewDate()
    {
        traceLog(post());
    }

    /**
     * onChangeBreakdownType writes the posted breakdown type to the trace log, testing a change handler on a dropdown.
     */
    public function onChangeBreakdownType()
    {
        traceLog(post('Review[breakdown_type]'));
    }

    /**
     * listExtendQuery filters reviews by the tab chosen in the query string.
     */
    public function listExtendQuery($query, $definition = null)
    {
        if (get('filter') === 'positive') {
            $query->where('is_positive', true);
        }
        elseif (get('filter') === 'negative') {
            $query->where('is_positive', false);
        }
    }

    /**
     * onRefreshList refreshes the list and its tabs together.
     */
    public function onRefreshList()
    {
        return array_merge($this->listRefresh(), [
            '#' . $this->getId('listTabs') => $this->makePartial('list_tabs')
        ]);
    }
}
