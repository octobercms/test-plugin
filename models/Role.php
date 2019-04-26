<?php namespace October\Test\Models;

use Model;

/**
 * Role Model
 */
class Role extends Model
{
    use \October\Rain\Database\Traits\Purgeable;

    public $purgeable = [
        'pivot'
    ];

    /**
     * @var array
     */
    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    /**
     * @var array
     */
    public $translatable = ['name', 'description'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_roles';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'users' => ['October\Test\Models\User', 'table' => 'october_test_users_roles']
    ];

    public $attachMany = [
        'photos' => ['System\Models\File'],
    ];



    /**
     * This wil only have effect if this model does not implements Translatable
     * @param $fields
     */
    public function filterFields($fields)
    {
        if (property_exists($fields, 'pivot[is_executive]')) {
            if ($fields->{'pivot[is_executive]'}->value == true)
                $fields->{'pivot[clearance_level]'}->value = 'Very secret';
            else
                $fields->{'pivot[clearance_level]'}->value = 'Not so secret actually';
        }
    }
}