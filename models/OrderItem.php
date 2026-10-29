<?php namespace October\Test\Models;

use Model;

/**
 * OrderItem is a line on an order, created by picking a product from the order form.
 */
class OrderItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_order_items';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'title' => 'required',
        'quantity' => 'required|integer|min:1',
        'price' => 'nullable|numeric|min:0',
    ];

    /**
     * @var array belongsTo relations, where product includes soft deleted products so existing lines keep their product
     */
    public $belongsTo = [
        'order' => Order::class,
        'product' => [Product::class, 'scope' => 'withTrashed'],
    ];

    /**
     * fillFromProduct copies the title and price from the picked product.
     */
    public function fillFromProduct(Product $product): void
    {
        $this->product = $product;
        $this->title = $product->title;
        $this->price = $product->price;
        $this->quantity = 1;
    }

    /**
     * beforeSave takes the price from the product unless the price was set manually.
     */
    public function beforeSave()
    {
        if (!$this->is_price_override && $this->product) {
            $this->price = $this->product->price;
        }
    }

    /**
     * getTotalAttribute returns the line total for the list column.
     */
    public function getTotalAttribute(): float
    {
        return (float) $this->price * (int) $this->quantity;
    }
}
