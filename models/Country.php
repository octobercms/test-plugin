<?php namespace October\Test\Models;

use Str;
use Model;
use Cms\Classes\Page;

/**
 * Country Model
 */
class Country extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * implement the TranslatableModel behavior softly
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_countries';

    /**
     * @var array guarded fields
     */
    protected $guarded = [];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array jsonable fields
     */
    protected $jsonable = ['pages', 'states', 'locations', 'content', 'notes', 'footer'];

    /**
     * @var array translatable
     */
    public $translatable = ['name', 'states', 'content', 'footer', 'is_active'];

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array hasMany
     */
    public $hasMany = [
        'cities' => [
            City::class,
            'key' => 'custom_country_id'
        ],
        'sisters' => [
            RepeaterItem::class,
            'key' => 'parent_id',
            'delete' => true
        ],
        'brothers' => [
            CountryBrother::class,
            'key' => 'parent_id',
            'delete' => true
        ]
    ];

    /**
     * @var array belongsToMany
     */
    public $belongsToMany = [
        'types' => [
            Attribute::class,
            'table' => 'october_test_countries_types',
            'conditions' => "type = 'general.type'"
        ],
    ];

    /**
     * @var array hasManyThrough
     */
    public $hasManyThrough = [
        'posts' => [
            Post::class,
            'through' => User::class
        ],
    ];

    /**
     * filterFields
     */
    public function filterFields($fields, $context = null)
    {
        // Repeater field shares this logic
        if (!isset($fields->pages_section)) {
            return;
        }

        if (empty($this->pages)) {
            $fields->pages_section->hidden = false;
        }
        else {
            $fields->pages_section->hidden = true;
        }

        if ($this->is_active) {
            $fields->currency->hidden = true;
        }

        if (isset($fields->_some_field)) {
            $fields->_some_field->value = Str::random();
        }
    }

    public function getPagesOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getCountryOptions()
    {
        return self::lists('name', 'id');
    }

    public function getStateOptions($value, $data)
    {
        $countryId = isset($data->country)
            ? $data->country
            : key($this->getCountryOptions());

        $country = self::find($countryId);

        return collect($country->states)->lists('title');
    }

    public function getSafetyDataTableOptions($column, $data)
    {
        if ($column === 'type') {
            return [
                'Petty' => 'Petty',
                'Minor' => 'Minor',
                'Major' => 'Major',
                'Capital' => 'Capital',
            ];
        }

        return [];
    }
}
