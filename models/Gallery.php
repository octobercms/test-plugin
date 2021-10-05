<?php

namespace October\Test\Models;

use Model;

class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_galleries';

    /**
     * @var array dates
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
    ];

    public $rules = [
        'title' => 'required|between:3,255',
        'start_date' => 'required',
        'end_date' => 'required_if:is_all_day,1',
        'start_time' => 'required_if:is_all_day,0',
        'end_time' => 'required_if:is_all_day,0',
    ];

    /**
     * @var array Relations
     */
    public $morphedByMany = [
        'posts' => [
            Post::class,
            'name' => 'entity',
            'table' => 'october_test_gallery_entity'
        ],
    ];

    public $attachMany = [
        'images' => \System\Models\File::class,
    ];

    /**
     * filterFields
     */
    public function filterFields($fields)
    {
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
