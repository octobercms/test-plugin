<?php namespace October\Test\Models;

use Model;

/**
 * Person Model
 */
class Person extends Model
{
    use \October\Rain\Database\Traits\Nullable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_people';

    /**
     * @var array attributes with default values for new records, testing a model driven default for preferred_name
     */
    public $attributes = [
        'preferred_name' => 'Joey',
    ];

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name', 'preferred_name', 'is_married', 'hobbies', 'sports'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['hobbies', 'sports'];

    /**
     * @var array nullable attributes set to null when empty
     */
    protected $nullable = ['is_married'];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = ['birth', 'birthdate'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
        'email' => 'nullable|email',
    ];

    /**
     * @var array hasOne relations, where phone uses a scope and alt_phone matches on the alt_id column
     */
    public $hasOne = [
        'phone' => [
            \October\Test\Models\Phone::class,
            'key' => 'person_id',
            'scope' => 'isActive'
        ],
        'alt_phone' => [
            \October\Test\Models\Phone::class,
            'key' => 'person_id',
            'otherKey' => 'alt_id',
        ]
    ];

    /**
     * afterCreate sets an alternative ID, used by the alt_phone relation to test hasOne with otherKey on a column other than the primary key.
     */
    public function afterCreate()
    {
        $altId = $this->id + 100;

        $this->newQueryWithoutScopes()
            ->where($this->getKeyName(), $this->id)
            ->update(['alt_id' => $altId])
        ;

        $this->alt_id = $altId;
    }
}
