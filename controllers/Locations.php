<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Locations Back-end Controller
 */
class Locations extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'locations');
    }

    /**
     * formExtendModel eager loads the attachment relations
     * @todo in v4 this can be replaced with a single method call i.e loadAttachments()
     */
    public function formExtendModel($model)
    {
        if ($model->exists) {
            $foundFiles = \System\Models\File::where('attachment_id', $model->getKey())
                ->where('attachment_type', get_class($model))
                ->get()
                ->groupBy('field')
                ->all();

            foreach ($model->getRelationDefinitions() as $type => $relations) {
                if ($type !== 'attachOne' && $type !== 'attachMany') {
                    continue;
                }

                foreach ($relations as $relation => $definition) {
                    if (isset($foundFiles[$relation])) {
                        $files = $foundFiles[$relation];
                        if ($type === 'attachOne') {
                            $model->setRelation($relation, $files->first());
                        }
                        else {
                            $model->setRelation($relation, $files);
                        }
                    }
                    else {
                        $model->setRelation($relation, null);
                    }
                }

            }
        }
    }
}
