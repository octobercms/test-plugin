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
}
