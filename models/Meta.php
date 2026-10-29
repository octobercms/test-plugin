<?php namespace October\Test\Models;

use Model;

/**
 * Meta holds the SEO fields of a plugin or theme through their taggable morphOne relation.
 */
class Meta extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_meta';

    /**
     * @var bool timestamps disabled, since the table has no timestamp columns
     */
    public $timestamps = false;

    /**
     * @var array morphTo relations, where taggable is the plugin or theme that owns the meta
     */
    public $morphTo = [
        'taggable' => []
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'meta_title' => 'required',
        'meta_description' => 'required',
        'meta_keywords' => 'required',
        'canonical_url' => 'url',
        'redirect_url' => 'url'
    ];

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'redirect_url',
        'robot_index',
        'robot_follow'
    ];
}
