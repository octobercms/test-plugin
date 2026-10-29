<?php namespace October\Test\Models;

use Model;

/**
 * Layout is a page layout, edited inside the page form through a nested form that uses the relation.
 */
class Layout extends Model
{
    /**
     * @var bool timestamps disabled, since the table has no timestamp columns
     */
    public $timestamps = false;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_layouts';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = [
        'content'
    ];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = [
        'content'
    ];
}
