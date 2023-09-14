<?php namespace October\Test\Models;

use Model;
use October\Test\Classes\StatusEnum;

/**
 * Company Model
 */
class Company extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Multisite;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_companies';

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array propagatable list of attributes to propagate to other sites.
     */
     protected $propagatable = [];

    /**
     * @var bool propagatableSync will enforce model structures between all sites
     */
     protected $propagatableSync = true;
}
