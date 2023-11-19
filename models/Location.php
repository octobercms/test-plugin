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
     * attachOne relations
     */
    public $attachOne = [
        'file01' => \System\Models\File::class,
        'file02' => \System\Models\File::class,
        'file03' => \System\Models\File::class,
        'file04' => \System\Models\File::class,
        'file05' => \System\Models\File::class,
        'file06' => \System\Models\File::class,
        'file07' => \System\Models\File::class,
        'file08' => \System\Models\File::class,
        'file09' => \System\Models\File::class,
        'file10' => \System\Models\File::class,
        'file11' => \System\Models\File::class,
        'file12' => \System\Models\File::class,
        'file13' => \System\Models\File::class,
        'file14' => \System\Models\File::class,
        'file15' => \System\Models\File::class,
        'file16' => \System\Models\File::class,
        'file17' => \System\Models\File::class,
        'file18' => \System\Models\File::class,
        'file19' => \System\Models\File::class,
        'file20' => \System\Models\File::class,
        'file21' => \System\Models\File::class,
        'file22' => \System\Models\File::class,
        'file23' => \System\Models\File::class,
        'file24' => \System\Models\File::class,
    ];

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
}
