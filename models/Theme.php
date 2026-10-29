<?php namespace October\Test\Models;

use Model;

/**
 * Theme Model
 */
class Theme extends Model
{
    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_themes';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name', 'code'];

    /**
     * @var array morphMany relations, where the review morph is named "product" for every model that can be reviewed
     */
    public $morphMany = [
        'reviews' => [Review::class, 'name' => 'product'],
    ];

    /**
     * @var array morphOne relations
     */
    public $morphOne = [
        'meta' => [Meta::class, 'name' => 'taggable'],
    ];
}
