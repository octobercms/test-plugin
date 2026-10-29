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
    public $rules = [
        'title' => 'required',
    ];

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['title', 'line_items', 'blocks', 'block_groups'];

    /**
     * @var array jsonable attributes stored as JSON, where line_items, blocks and block_groups hold datatable rows
     */
    protected $jsonable = ['line_items', 'blocks', 'block_groups'];

    /**
     * @var array hasMany relations, where items are the order lines picked from products
     */
    public $hasMany = [
        'items' => [OrderItem::class, 'delete' => true],
    ];

    /**
     * @var array belongsToMany relations, where products tests a relation controller defined inline in the form
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
