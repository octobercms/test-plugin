<?php namespace October\Test\Models;

use October\Rain\Database\Pivot;

/**
 * UserRolePivot Model
 */
class UserRolePivot extends Pivot
{
    use \October\Rain\Database\Traits\Nullable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model, although the User roles and Role users relations pass this table and supply it at runtime
     */
    public $table = 'october_test_users_roles';

    /**
     * @var bool incrementing identifier
     */
    public $incrementing = true;

    /**
     * @var array nullable attributes set to null when empty
     */
    protected $nullable = ['evolution'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'clearance_level' => 'required|min:3',
    ];

    /**
     * @var array belongsTo relations, where country is picked with a record finder inside the pivot form
     */
    public $belongsTo = [
        'country' => Country::class,
    ];

    /**
     * @var array attachOne relations
     */
    public $attachOne = [
        // Testing an attachment on a pivot model, which is unsupported, to see how the pivot form handles a file upload
        'pic' => \System\Models\File::class
    ];

    /**
     * getEvolutionOptions returns the evolution stages for the pivot evolution dropdown.
     */
    public function getEvolutionOptions()
    {
        return [
            1 => 'Primate',
            2 => 'Humanoid',
            3 => 'Homo Sapiens',
        ];
    }
}
