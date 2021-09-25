<?php namespace October\Test\Models;

use Str;
use Model;
use Cms\Classes\Page;

/**
 * Country Model
 */
class Country extends Model
{
    /**
     * implement the TranslatableModel behavior softly
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_countries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Jsonable fields
     */
    protected $jsonable = ['pages', 'states', 'locations', 'content'];

    /**
     * translatable
     */
    public $translatable = ['name', 'states', 'content'];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'types' => [
            Attribute::class,
            'table' => 'october_test_countries_types',
            'conditions' => "type = 'general.type'"
        ],
    ];

    public $hasManyThrough = [
        'posts' => [
            Post::class,
            'through' => User::class
        ],
    ];

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
