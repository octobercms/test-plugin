<?php namespace October\Test\Models;

use Model;

/**
 * ProductCategory Model
 */
class ProductCategory extends Model
{
    use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_product_categories';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array propagatable list of attributes to propagate to other sites.
     */
    public $propagatable = [];

    /**
     * @var bool propagatableSync will enforce model structures between all sites
     */
    protected $propagatableSync = true;
}
