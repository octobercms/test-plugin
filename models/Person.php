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
     * @var string The database table used by the model.
     */
    public $table = 'october_test_people';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array List of attribute names which are json encoded and decoded from the database.
     */
    protected $jsonable = ['hobbies', 'sports'];

    /**
     * @var array List of attribute names which should be set to null when empty.
     */
    protected $nullable = ['is_married'];

    /**
     * @var array Dates
     */
    public $dates = ['birth', 'birthdate'];

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array Relations
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
     * filterFields
     */
    public function filterFields($fields)
    {
        // $fields->phone->hidden = true;
    }

    /**
     * __construct
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Default value, model driven
        $this->preferred_name = 'Joey';
    }

    /**
     * afterCreate
     */
    public function afterCreate()
    {
        // Spoof a alternative ID
        $altId = $this->id + 100;

        $this->newQueryWithoutScopes()
            ->where($this->getKeyName(), $this->id)
            ->update(['alt_id' => $altId])
        ;

        $this->alt_id = $altId;
    }
}
