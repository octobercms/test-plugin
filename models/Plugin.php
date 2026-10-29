<?php namespace October\Test\Models;

use Model;

/**
 * Plugin Model
 */
class Plugin extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_plugins';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
        'code' => 'required',
        'content' => 'required'
    ];

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
