<?php namespace October\Test\Models;

use Model;

/**
 * Company Model
 */
class Company extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Multisite;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_companies';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array propagatable attributes to copy to other sites
     */
    protected $propagatable = [];

    /**
     * @var bool propagatableSync keeps the record structure the same across all sites
     */
    protected $propagatableSync = true;
}
