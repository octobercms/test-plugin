<?php

namespace October\Test\Models;

use Model;

class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SortableRelation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_galleries';

    /**
     * @var array dates
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
    ];

    public $rules = [
        'title' => 'required|uppercase:strict|between:3,255',
        'subtitle' => 'required|betwixt:3,20',
        'start_date' => 'required',
        'end_date' => 'required_if:is_all_day,1',
        'start_time' => 'required_if:is_all_day,0',
        'end_time' => 'required_if:is_all_day,0',
    ];

    /**
     * @var array morphedByMany
     */
    public $morphedByMany = [
        'posts' => [
            Post::class,
            'name' => 'entity',
            'table' => 'october_test_gallery_entity'
        ],
    ];

    /**
     * @var array belongsToMany
     */
    public $belongsToMany = [
        'countries' => [
            Country::class,
            'table' => 'october_test_galleries_countries',
            'pivotSortable' => 'sort_order',
        ]
    ];

    /**
     * @var array attachMany
     */
    public $attachMany = [
        'images' => \System\Models\File::class,
    ];

    /**
     * beforeValidate
     */
    public function beforeValidate()
    {
        $this->rules['subtitle'] = ['required', 'betwixt:3,255', new \October\Test\Classes\LowercaseRule];
    }

    /**
     * filterFields
     */
    public function filterFields($fields)
    {
        // Simple scope
        if (!isset($fields->start_time)) {
            return;
        }

        if (!$this->is_all_day) {
            $fields->start_time->hidden = false;
            $fields->end_time->hidden = false;
            $fields->end_date->hidden = true;
        }
        else {
            $fields->start_time->hidden = true;
            $fields->end_time->hidden = true;
            $fields->end_date->hidden = false;
        }
    }
}
