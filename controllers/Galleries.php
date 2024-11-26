<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Galleries Back-end Controller
 */
class Galleries extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['october.test.access_plugin'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'galleries');

        \Event::listen('backend.form.extendFields', static function ($form) {
            if ($form->getController() instanceof \October\Test\Controllers\Galleries) {
                if ($posts = $form->getField('posts')) {
                    $posts->readOnly = true;
                    // $posts->previewMode = true;
                }
            }
        });
    }
}
