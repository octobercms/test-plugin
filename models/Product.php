<?php namespace October\Test\Models;

use Model;

/**
 * Product Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_products';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var mixed attributes that aren't mass assignable.
     */
    protected $guarded = false;

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array propagatable list of attributes to propagate to other sites.
     */
    public $propagatable = ['price'];

    /**
     * @var bool propagatableSync will enforce model structures between all sites
     */
    protected $propagatableSync = true;

    /**
     * @var array belongsToMany and other relations
     */
    public $belongsToMany = [
        'categories' => [
            ProductCategory::class,
            'table' => 'october_test_products_categories',
            'key' => 'product_id',
            'otherKey' => 'category_id',
            'relatedKey' => 'site_root_id'
        ]
    ];

    public $attachOne = [
        'certificate' => \System\Models\File::class
    ];

    public $attachMany = [
        'gallery' => \System\Models\File::class
    ];
}
