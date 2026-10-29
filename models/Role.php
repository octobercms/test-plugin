<?php namespace October\Test\Models;

use Model;

/**
 * Role Model
 */
class Role extends Model
{
    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_roles';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name'];

    /**
     * @var array belongsToMany relations
     */
    public $belongsToMany = [
        'users' => [User::class, 'table' => 'october_test_users_roles']
    ];

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        'photos' => \System\Models\File::class,
    ];

    /**
     * scopeApplyRoleOptionsFilter leaves out the first role, used as the optionsScope of the roles filter on users.
     */
    public function scopeApplyRoleOptionsFilter($query)
    {
        return $query->where('id', '<>', 1);
    }
}
