<?php namespace October\Test\Models;

use Model;

/**
 * Page
 */
class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * implement the TranslatableModel behavior softly
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var bool timestamps disabled by default
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_pages';

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [
        'content',
        'mainimage'
    ];

    /**
     * @var array translatable
     */
    public $translatable = [
        'content',
        'mainimage'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'type' => 'required',
        'content.title' => 'required|min:3'
    ];

    public $belongsTo = [
        'layout' => Layout::class,
    ];
}
