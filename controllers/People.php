<?php namespace October\Test\Controllers;

use Mail;
use Flash;
use Response;
use BackendMenu;
use AjaxException;
use October\Test\Models\Phone;
use Backend\Classes\Controller;

/**
 * People Backend Controller
 */
class People extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
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
     * @var array requiredPermissions to view this page
     */
    public $requiredPermissions = ['october.test.access_plugin'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'people');
    }

    /**
     * create page highlights the New Person side menu item.
     */
    public function create()
    {
        BackendMenu::setContextSideMenu('people_create');

        return $this->asExtension('FormController')->create();
    }

    /**
     * onShowAjaxError throws an error carrying custom data, which the list toolbar button reads in its error handler.
     */
    public function onShowAjaxError()
    {
        throw new AjaxException(['messageFromData' => 'This message came from a smart error 406.']);
    }

    /**
     * onShowFlashMessage shows a flash message.
     */
    public function onShowFlashMessage()
    {
        Flash::success('All good');
    }

    /**
     * onModalShowTest renders the test popup.
     */
    public function onModalShowTest()
    {
        return $this->makePartial('test_modal');
    }

    /**
     * onSendTestEmail sends one message for each way the Mail facade can compose a message.
     */
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

        // Database stored
        Mail::sendTo('test@email.tld', 'october.test::mail.test-message', ['user' => 'Some Guy']);

        Flash::success('Done');
    }

    /**
     * formExtendModel sets a default for a form-only field and creates the phone used by the proxy fields context.
     */
    public function formExtendModel($model)
    {
        if ($this->formGetContext() === 'create') {
            $model->_previous_names = 'Hippo, Campus';
        }

        if ($this->formGetContext() === 'proxyfields' && !$model->phone) {
            $model->phone = new Phone;
        }

        return $model;
    }

    /**
     * formGetConfig opens the Activities tab by default, testing a form config changed at runtime.
     */
    public function formGetConfig()
    {
        $config = $this->asExtension('FormController')->formGetConfig();

        $config->form = $this->makeConfig($config->form);

        $config->form->tabs['activeTab'] = 'Activities';

        return $config;
    }

    /**
     * onGetOptions returns the options for the AJAX select on the person form.
     */
    public function onGetOptions()
    {
        $results = [
            'key' => 'value',
            'foo' => 'bar',
            'baz' => 'baz'
        ];

        return ['result' => $results];
    }

    /**
     * onDownloadOrPrompt randomly shows a popup or downloads a file, testing both responses from one handler.
     */
    public function onDownloadOrPrompt()
    {
        if (rand() % 2 === 0) {
            return $this->makePartial('download_prompt');
        }

        return Response::streamDownload(function () {
            echo "name,phone\nJoe Dirt,555-0100\n";
        }, 'people.csv', ['Content-Type' => 'text/csv']);
    }
}
