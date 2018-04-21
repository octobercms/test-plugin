<?php namespace October\Test\Models;

use Model;

/**
 * NestedGroupRepeater Model
 */
class NestedGroupRepeater extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_nested_group_repeaters';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
    protected $jsonable = ['repeater_data', 'group_repeater_data'];

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
}
