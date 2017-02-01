<?php namespace October\Test\Models;

use Model;

/**
 * Post Model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_posts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'comments' => ['October\Test\Models\Comment', 'scope' => 'isVisible'],
        'comments_count' => ['October\Test\Models\Comment', 'scope' => 'isVisible', 'count' => true]
    ];

    public $belongsTo = [
        'status' => ['October\Test\Models\Attribute', 'conditions' => "type = 'general.status'"],
    ];

    public $morphOne = [
        'review' => ['October\Test\Models\Review', 'name' => 'product'],
    ];

    public $morphToMany = [
        'galleries' => ['October\Test\Models\Gallery', 'name' => 'entity', 'table' => 'october_test_gallery_entity'],
    ];
}
