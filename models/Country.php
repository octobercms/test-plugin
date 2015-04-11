<?php namespace October\Test\Models;

use Model;
use Cms\Classes\Page;

/**
 * Country Model
 */
class Country extends Model
{

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
    protected $jsonable = ['pages'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function filterFields($fields, $context = null)
    {
        if (empty($this->pages)) {
            $fields->pages_section->hidden = true;
        }
        else {
            $fields->pages_section->hidden = false;
        }
    }

    public function getPagesOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

}