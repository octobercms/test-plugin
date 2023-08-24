<?php namespace October\Test\Models;

use Model;

/**
 * Order Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_orders';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var mixed attributes that aren't mass assignable.
     */
    protected $guarded = false;

    /**
     * @var array belongsToMany
     */
    public $belongsToMany = [
        'products' => [
            Product::class,
            'table' => 'october_test_orders_products',
            'key' => 'order_id',
            'otherKey' => 'product_id',
        ],
    ];
}
