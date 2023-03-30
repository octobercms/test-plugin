<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Pages Back-end Controller
 */
class Pages extends Controller
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

        BackendMenu::setContext('October.Test', 'test', 'pages');
    }

    /**
     * update action
     */
    public function update(...$args)
    {
        $this->bodyClass = 'compact-container';

        return $this->asExtension('FormController')->update(...$args);
    }

    /**
     * formExtendRefreshData manipulates the data
     * @see October\Test\Models\Page::filterFields
     */
    public function formExtendRefreshData($form, $data)
    {
        if (array_key_exists('_prepopulate_people', $data)) {
            if ($data['_prepopulate_people']) {
                $data['people'] = [
                    ['description' => 'First Person'],
                    ['description' => 'Second Person']
                ];
            }
            else {
                $data['people'] = [];
            }
        }

        return $data;
    }
}
