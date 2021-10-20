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

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

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
    protected $jsonable = ['slave_repiter'];

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
