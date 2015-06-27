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
        'roles' => ['October\Test\Models\Role', 'table' => 'october_test_users_roles'],
        'roles_count' => ['October\Test\Models\Role', 'table' => 'october_test_users_roles', 'count' => true]
    ];

    public $attachOne = [
        'photo' => ['System\Models\File'],
        'photo_secure' => ['System\Models\File', 'public' => false],
        'certificate' => ['System\Models\File'],
        'certificate_secure' => ['System\Models\File', 'public' => false],
    ];

    public $attachMany = [
        'portfolio' => ['System\Models\File'],
        'portfolio_secure' => ['System\Models\File', 'public' => false],
        'files' => ['System\Models\File'],
        'files_secure' => ['System\Models\File', 'public' => false],
    ];


}