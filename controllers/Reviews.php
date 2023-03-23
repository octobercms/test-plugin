<?php namespace October\Test\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Reviews Back-end Controller
 */
class Reviews extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'reviews');
    }

    /**
     * onChangeContent
     */
    public function onChangeContent()
    {
        Flash::success('Great job!');

        return $this->formRefreshFields(['_internal_comments', 'is_positive']);
    }

    /**
     * onChangeReviewDate
     */
    public function onChangeReviewDate()
    {
        traceLog(post());
    }
}
