<?php namespace October\Test\Models;

use Model;

/**
 * Location Model
 */
class Location extends Model
{
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;

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
     * @var array fillable fields
     */
    protected $fillable = ['custom_country_id', 'city_id', 'name'];

    /**
     * @var array jsonable fields
     */
    protected $jsonable = ['available_services'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'country' => Country::class,
        'city' => City::class,
    ];

    /**
     * getCountryOptions
     */
    public function getCountryOptions()
    {
        return Country::lists('name', 'id');
    }

    /**
     * getCityOptions
     */
    public function getCityOptions($scopes = null)
    {
        if ($scopes->country && ($selectedId = $scopes->country->value)) {
            return City::whereIn('custom_country_id', $selectedId)->lists('name', 'id');
        }

        return City::lists('name', 'id');
    }

    public function filterFields($fields, $context = null)
    {
        //trying to get by $this->relation
        if ($this->country?->code == 'petoria' && $context == 'refresh') {
            $fields->city->hidden = true;
        } else {
            $fields->city->hidden = false;
        }

        //trying to get the value that should contain the ID of the record.
        if ($fields->country?->value == 1 && $context == 'refresh') {
            $fields->city->hidden = true;
        } else {
            $fields->city->hidden = false;
        }
    }
}
