<?php namespace October\Test\Models;

use Date;
use Model;

/**
 * Gallery tests registered rule classes, rule objects and rules that change at validation time, along with date fields controlled by filterFields.
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SortableRelation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_galleries';

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['gallery'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'title' => 'required|all_caps:strict|between:3,255',
        // Replaced by beforeValidate, testing rules that change at validation time
        'subtitle' => 'required|betwixt:3,20',
        'start_date' => 'required',
        'end_date' => 'required_if:is_all_day,1',
        'start_time' => 'required_if:is_all_day,0',
        'end_time' => 'required_if:is_all_day,0',
    ];

    /**
     * @var array morphedByMany relations
     */
    public $morphedByMany = [
        'posts' => [
            Post::class,
            'name' => 'entity',
            'table' => 'october_test_gallery_entity'
        ],
    ];

    /**
     * @var array belongsToMany relations
     */
    public $belongsToMany = [
        'countries' => [
            Country::class,
            'table' => 'october_test_galleries_countries',
            // Testing deferred binding on a relation with conditions and pivot sorting
            'conditions' => '1 = 1',
            'pivotSortable' => 'sort_order',
        ]
    ];

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        'images' => \System\Models\File::class,
    ];

    /**
     * beforeValidate replaces the subtitle rules with a registered rule and a local rule object.
     */
    public function beforeValidate()
    {
        $this->rules['subtitle'] = ['required', 'betwixt:3,255', new \October\Test\Classes\LowercaseRule];
    }

    /**
     * filterFields shows the time fields or the end date depending on is_all_day, and always disables today in the start date picker.
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

        // Always disable today
        if ($fields->start_date) {
            $fields->start_date->disableDays = array_merge(
                (array) $fields->start_date->disableDays,
                [Date::now()->format('Y-m-d')]
            );
        }
    }

    /**
     * getAllDisabledDatesForEndDate returns yesterday, today and tomorrow, used as a static disableDays callable by the end date field.
     */
    public static function getAllDisabledDatesForEndDate()
    {
        return [
            Date::now()->format('Y-m-d'),
            Date::now()->addDays(1)->format('Y-m-d'),
            Date::now()->addDays(-1)->format('Y-m-d')
        ];
    }
}
