<?php namespace October\Test\Models;

use Str;
use Model;
use Cms\Classes\Page;

/**
 * Country Model
 */
class Country extends Model
{
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Translatable;
    // Testing a single default record across the whole table, stored in the is_default column
    use \October\Rain\Database\Traits\Defaultable;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_countries';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name', 'code'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['pages', 'states', 'locations', 'content', 'notes', 'footer'];

    /**
     * @var array translatable attributes stored per locale
     */
    public $translatable = ['name', 'states', 'content', 'footer', 'is_active'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array hasMany relations, where sisters and brothers store relation repeater items
     */
    public $hasMany = [
        'cities' => [
            City::class,
            // Testing a custom foreign key name
            'key' => 'custom_country_id',
            // Testing deferred binding on a relation with conditions
            'conditions' => '2 = 2'
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
     * @var array belongsToMany relations, where types shares the attributes table with other types using conditions
     */
    public $belongsToMany = [
        'types' => [
            Attribute::class,
            'table' => 'october_test_countries_types',
            'conditions' => "type = 'general.type'"
        ],
    ];

    /**
     * @var array hasManyThrough relations, where posts are written by users from this country
     */
    public $hasManyThrough = [
        'posts' => [
            Post::class,
            'through' => User::class
        ],
    ];

    /**
     * @var array hasOneThrough relations
     */
    public $hasOneThrough = [
        // Testing hasOneThrough, which returns one post written by a user from this country
        'post' => [
            Post::class,
            'through' => User::class
        ],
    ];

    /**
     * getCountryNameCustomAttribute wraps the name in brackets, used as the nameFrom attribute of the location country field.
     */
    public function getCountryNameCustomAttribute()
    {
        return "[{$this->name}]";
    }

    /**
     * filterFields shows the pages section until a page is picked, hides the currency for active countries and fills _some_field with a random value.
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

    /**
     * getPagesOptions returns the CMS page file names of the active theme for the pages checkbox list.
     */
    public function getPagesOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * getCountryOptions returns every country name keyed by ID for the country dropdown in the locations repeater.
     */
    public function getCountryOptions()
    {
        return self::lists('name', 'id');
    }

    /**
     * getStateOptions returns the state titles of the country picked in the same repeater item, testing dropdown options that depend on another field.
     */
    public function getStateOptions($value, $data)
    {
        $countryId = isset($data->country)
            ? $data->country
            : key($this->getCountryOptions());

        $country = self::find($countryId);

        return collect($country?->states)->pluck('title')->all();
    }

    /**
     * getSafetyDataTableOptions returns the dropdown options for the type column of the safety datatable in the states repeater.
     */
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
