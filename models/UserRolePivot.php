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
     * @var array nullable attribute names which should be set to null when empty.
     */
    protected $nullable = ['evolution'];

    /**
     * @var array Rules
     */
    public $rules = [
        'clearance_level' => 'required|min:3',
    ];

    public $belongsTo = [
        'country' => Country::class,
    ];

    // Unsupported
    public $attachOne = [
        'pic' => \System\Models\File::class
    ];

    /**
     * getEvolutionOptions
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
