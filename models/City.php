<?php namespace October\Test\Models;

use Model;

/**
 * City Model
 */
class City extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_cities';

    /**
     * @var bool timestamps disabled, since the table has no timestamp columns
     */
    public $timestamps = false;

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['custom_country_id', 'name'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'country' => 'required'
    ];

    /**
     * @var array hasMany relations
     */
    public $hasMany = [
        'locations' => Location::class
    ];

    /**
     * @var array belongsTo relations
     */
    public $belongsTo = [
        'country' => [
            Country::class,
            // Testing a custom foreign key name
            'key' => 'custom_country_id'
        ],
    ];
}
