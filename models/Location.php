<?php namespace October\Test\Models;

use Model;

/**
 * Location Model
 */
class Location extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_locations';

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['country_id', 'city_id', 'name'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'country' => Country::class,
        'city'    => City::class,
    ];

    public function getCountryOptions()
    {
        return Country::lists('name', 'id');
    }

    public function getCityOptions($scopes = null)
    {
        if (!empty($scopes['country']->value)) {
            return City::whereIn('country_id', array_keys($scopes['country']->value))->lists('name', 'id');
        } else {
            return City::lists('name', 'id');
        }
    }
}
