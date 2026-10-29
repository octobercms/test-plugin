<?php namespace October\Test\Models;

use Model;

/**
 * ProductCategory Model
 */
class ProductCategory extends Model
{
    use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\NestedTree;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_product_categories';

    /**
     * @var array propagatable attributes to copy to other sites
     */
    protected $propagatable = [];

    /**
     * @var bool propagatableSync keeps the record structure the same across all sites
     */
    protected $propagatableSync = true;
}
