<?php namespace October\Test\Models;

use Model;

/**
 * Various Tests Model
 */
class Tests extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_tests';

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
    protected $jsonable = ['checkbox1', 'checkbox2'];

}