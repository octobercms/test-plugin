<?php namespace October\Test\Models;

use Model;

/**
 * Review Model
 */
class Review extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_reviews';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['feature_color'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['breakdown', 'meta'];

    /**
     * @var array rules for validation, where breakdown.*.aspect validates every repeater item
     */
    public $rules = [
        'feature_color' => 'required',
        'breakdown.*.aspect' => 'required',
    ];

    /**
     * @var array morphTo relations, where product is the reviewed model and can be a Post, Plugin or Theme
     */
    public $morphTo = [
        'product' => []
    ];

    /**
     * @var array attachOne relations
     */
    public $attachOne = [
        'photo' => \System\Models\File::class
    ];
}
