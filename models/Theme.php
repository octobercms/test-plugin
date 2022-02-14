<?php namespace October\Test\Models;

use Model;

/**
 * Theme Model
 */
class Theme extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_themes';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $morphMany = [
        'reviews' => [Review::class, 'name' => 'product'],
    ];

    public $morphOne = [
        'meta' => [Meta::class, 'name' => 'taggable'],
    ];
}