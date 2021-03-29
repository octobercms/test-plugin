<?php namespace October\Test\Models;

use Model;

/**
 * Model
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

    public $fillable = [
        'content'
    ];

    public $jsonable = [
        'content'
    ];
}
