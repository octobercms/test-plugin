<?php

namespace October\Test\Models;

use Model;
use October\Rain\Database\Traits\Validation;

class Gallery extends Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_galleries';

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
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphedByMany = [
        'posts' => ['October\Test\Models\Post', 'name' => 'entity', 'table' => 'october_test_gallery_entity'],
    ];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'images' => ['System\Models\File', 'order' => 'sort_order'],
    ];
}