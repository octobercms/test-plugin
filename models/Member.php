<?php namespace October\Test\Models;

use Model;

/**
 * Member Model
 */
class Member extends Model
{

    use \October\Rain\Database\Traits\SimpleTree;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_members';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => 'October\Test\Models\User'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}