<?php namespace October\Test\Controllers;

use Mail;
use Flash;
use BackendMenu;
use October\Test\Models\Phone;
use Backend\Classes\Controller;
use Backend\FormWidgets\DataTable;
use AjaxException;

/**
 * People Back-end Controller
 */
class People extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'people');
    }

    public function onShowAjaxError()
    {
        throw new AjaxException(['messageFromData' => 'This message came from a smart error 406.']);
    }

    public function onSendTestEmail()
    {
        $data = ['msg' => 'Hello world'];
        $recptFunc = function($message) {
            $message->to('admin@domain.tld');
            $message->subject('Test message');
        };

        // Laravel engine
        Mail::send(['html' => 'october.test::mail.some_html', 'text' => 'october.test::mail.some_text'], $data, $recptFunc);
        Mail::raw(['text' => 'This is plain text', 'html' => '<strong>This is HTML</strong>'], $recptFunc);

        // October engine
        Mail::send(['text' => 'october.test::mail.some_text'], $data, $recptFunc);
        Mail::send(['html' => 'october.test::mail.some_html'], $data, $recptFunc);
        Mail::send(['raw' => 'This is plain text'], $data, $recptFunc);
        Mail::rawTo('admin@domain.tld', 'Hello friend');
        Mail::send('october.test::mail.some_html', $data, $recptFunc);
        Mail::sendTo('admin@domain.tld', 'october.test::mail.some_html', $data);
        Mail::sendTo('admin@domain.tld', 'october.test::mail.with_template', $data);

        Flash::success('Done');
    }

    public function formExtendModel($model)
    {
        // Default value, form driven
        if ($this->formGetContext() === 'create') {
            $model->_previous_names = 'Hippo, Campus';
        }

        /*
         * Init proxy field model if we are creating the model
         * and the context is proxy fields.
         */
        if ($this->formGetContext() === 'proxyfields' && !$model->phone) {
            $model->phone = new Phone;
        }

        return $model;
    }

    public function onGetOptions()
    {
        $results = [
            'key' => 'value',
            'foo' => 'bar',
            'baz' => 'baz'
        ];

        return ['result' => $results];
    }

    public function onModelShowAddDatabaseColumnsPopup()
    {
        $config  = $this->makeConfig([
            'toolbar' => false,
            'columns' => [
                'type' => [
                    'title' => 'Widget Type',
                    'type' => 'dropdown',
                    'options' => [
                        'petty' => 'Petty',
                        'minor' => 'Minor',
                        'major' => 'Major',
                        'critical' => 'Critical'
                    ],
                ],
            ],
        ]);

        $datatable = $this->makeFormWidget(DataTable::class, 'add_database_columns', $config);
        $datatable->alias = 'add_database_columns_datatable';
        $datatable->bindToController();

        return $this->makePartial('datatable', [
            'datatable' => $datatable,
        ]);
    }
}
