<?php namespace October\Test\Models;

use Model;

/**
 * User Model
 */
class User extends Model
{

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_users';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Rules
     */
    public $rules = [
        'photo' => 'required',
        'portfolio' => 'required',
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'roles' => ['October\Test\Models\Role', 'table' => 'october_test_users_roles']
    ];

    public $attachOne = [
        'photo' => ['System\Models\File'],
        'certificate' => ['System\Models\File'],
    ];

    public $attachMany = [
        'portfolio' => ['System\Models\File'],
        'files' => ['System\Models\File'],
    ];


}