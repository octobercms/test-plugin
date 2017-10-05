<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Test\Models\Attribute;

/**
 * Posts [and Comments] Back-end Controller
 *
 * This is a mighty fine example of what October can do, here we have a single controller
 * managing two Models (Posts and Comments). The ListController behavior handles two lists
 * easily, by passing an array of definitions and config files. The FormController behavior
 * natively handles the Posts, but for Comments we intercept the construction process and
 * override the config to reference the comment form when a special flag is passed with the
 * request (comment_mode). By itself this is enough to simply tack ?comment_mode=1 on to the
 * URL, but to mix things up the Comments form is managed by AJAX popups.
 */
class Posts extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_post_form.yaml';
    public $listConfig = ['posts' => 'config_posts_list.yaml', 'comments' => 'config_comments_list.yaml'];
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        if (post('comment_mode')) {
            $this->formConfig = 'config_comment_form.yaml';
        }

        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'posts');
    }

    public function index()
    {
        $this->asExtension('ListController')->index();
        $this->bodyClass = 'compact-container';
    }

    public function formExtendModel($model)
    {
        /*
         * Init proxy field model if we are creating the model
         */
        if ($this->action == 'create') {
            $model->status = new Attribute();
        }

        return $model;
    }

    //
    // Custom Delete workflow
    //

    public function onLoadDeleteReasonForm($recordId = null)
    {
        return $this->makePartial('delete_reason_form');
    }

    public function onDeleteWithReason($recordId = null)
    {
        $result = $this->asExtension('FormController')->update_onDelete($recordId);

        $model = $this->formGetModel();

        $reason = post('reason');

        traceLog(sprintf('The post "%s" was deleted with reason "%s"', $model->name, $reason));

        return $result;
    }

    //
    // Comment form
    //

    public function onCreateForm()
    {
        $this->asExtension('FormController')->create();
        return $this->makePartial('create_form');
    }

    public function onCreate()
    {
        $this->asExtension('FormController')->create_onSave();
        return $this->listRefresh('comments');
    }

    public function onUpdateForm()
    {
        $this->asExtension('FormController')->update(post('record_id'));
        $this->vars['recordId'] = post('record_id');
        return $this->makePartial('update_form');
    }

    public function onUpdate()
    {
        $this->asExtension('FormController')->update_onSave(post('record_id'));
        return $this->listRefresh('comments');
    }

    public function onDelete()
    {
        $this->asExtension('FormController')->update_onDelete(post('record_id'));
        return $this->listRefresh('comments');
    }

}
