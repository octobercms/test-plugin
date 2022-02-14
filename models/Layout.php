<?php namespace October\Test\Models;

use Model;

/**
 * Layout
 */
class Layout extends Model
{
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_layouts';

    /**
     * @var array fillable fields
     */
    protected $fillable = [
        'content'
    ];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [
        'content'
    ];
}
