<?php namespace October\Test\Models;

use Model;

/**
 * Attribute Model
 */
class Attribute extends Model
{
    use \October\Rain\Database\Traits\Sortable;

    const GENERAL_STATUS = 'general.status';
    const GENERAL_TYPE = 'general.type';

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_attributes';
}
