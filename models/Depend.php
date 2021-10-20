<?php namespace October\Test\Models;

use Model;

/**
 * Depend Model
 */
class Depend extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_depend';

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
    protected $jsonable = ['repiter'];

    /**
     * @var array Rules
     */
    public $rules = [];

    /**
     * @var array Relations
     */
    public $hasMany = [];

    public $belongsTo = [];

    public $belongsToMany = [];

    public $morphOne = [];

    public $morphToMany = [];

    public function getMasterOptions()
    {
    	return [
    		'firstValue' => 'firstLabel',
    		'secondValue' => 'secondLabel',
    		'thirdValue' => 'thirdLabel',
    	];
    }

}
