<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Test\Models\Post;

/**
 * Posts Backend Controller manages posts, comments and tags, switching to the comment or tag form config when an AJAX request posts a comment_mode or tag_mode flag.
 */
class Posts extends Controller
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
     * @var string formConfig file, replaced by the comment or tag form config in the constructor
     */
    public $formConfig = 'config_post_form.yaml';

    /**
     * @var array listConfig files, one for each list on the index page
     */
    public $listConfig = [
        'posts' => 'config_posts_list.yaml',
        'comments' => 'config_comments_list.yaml',
        'tags' => 'config_tags_list.yaml'
    ];

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
     * __construct the controller, picking the form config before the behaviors read it
     */
    public function __construct()
    {
        $this->vars['mode'] = false;

        if (post('comment_mode')) {
            $this->vars['mode'] = 'comment';
            $this->formConfig = 'config_comment_form.yaml';
        }

        if (post('tag_mode')) {
            $this->vars['mode'] = 'tag';
            $this->formConfig = 'config_tag_form.yaml';
        }

        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'posts');
    }

    /**
     * index renders the lists in a compact container
     */
    public function index()
    {
        $this->asExtension('ListController')->index();

        $this->bodyClass = 'compact-container';
    }

    /**
     * formExtendFields shows the name with a lowercased first letter as a comment on the post form only, testing a field changed before display without touching the saved value.
     */
    public function formExtendFields($form, $fields)
    {
        if (!$form->model instanceof Post || !$form->model->name) {
            return;
        }

        if ($nameField = $form->getField('name')) {
            $nameField->comment = __("Lowercased: :name", ['name' => e(lcfirst($form->model->name))]);
        }
    }

    /**
     * relationExtendManageFormQuery includes deleted child comments when managing them.
     */
    public function relationExtendManageFormQuery($field, $query)
    {
        if ($field === 'comments[child_comments]') {
            $query->withTrashed();
        }
    }

    /**
     * onLoadDeleteReasonForm renders the popup that asks why the post is deleted.
     */
    public function onLoadDeleteReasonForm($recordId = null)
    {
        return $this->makePartial('delete_reason_form');
    }

    /**
     * onDeleteWithReason deletes the post and logs the reason given in the popup.
     */
    public function onDeleteWithReason($recordId = null)
    {
        $result = $this->asExtension('FormController')->update_onDelete($recordId);

        $model = $this->formGetModel();

        $reason = post('reason');

        traceLog(sprintf('The post "%s" was deleted with reason "%s"', $model->name, $reason));

        return $result;
    }

    /**
     * onLoadCreateForm renders the popup to create a comment or a tag.
     */
    public function onLoadCreateForm()
    {
        $this->asExtension('FormController')->create();

        return $this->makePartial('create_form');
    }

    /**
     * onCreateRecord saves a new comment or tag and refreshes both lists.
     */
    public function onCreateRecord()
    {
        $this->asExtension('FormController')->create_onSave();

        return array_merge($this->listRefresh('tags'), $this->listRefresh('comments'));
    }

    /**
     * onLoadUpdateForm renders the popup to update a comment or a tag.
     */
    public function onLoadUpdateForm()
    {
        $this->asExtension('FormController')->update(post('record_id'));

        $this->vars['recordId'] = post('record_id');

        return $this->makePartial('update_form');
    }

    /**
     * onUpdateRecord saves a comment or tag and refreshes both lists.
     */
    public function onUpdateRecord()
    {
        $this->asExtension('FormController')->update_onSave(post('record_id'));

        return array_merge($this->listRefresh('tags'), $this->listRefresh('comments'));
    }

    /**
     * onDeleteRecord deletes a comment or tag, named so it does not replace the list bulk delete handler.
     */
    public function onDeleteRecord()
    {
        $this->asExtension('FormController')->update_onDelete(post('record_id'));

        return array_merge($this->listRefresh('tags'), $this->listRefresh('comments'));
    }
}
