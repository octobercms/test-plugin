<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\Widgets\Form;
use October\Test\Models\Order;
use October\Test\Models\Product;
use October\Test\Models\OrderItem;
use October\Test\Controllers\Orders;

/**
 * OrderItemTest checks order items created by picking a product on the order form.
 */
class OrderItemTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testFillFromProductCopiesTitleAndPrice checks a new item starts from the picked product.
     */
    public function testFillFromProductCopiesTitleAndPrice()
    {
        $product = $this->makeProduct('Picked Widget', 12.5);

        $item = new OrderItem;
        $item->fillFromProduct($product);

        $this->assertEquals('Picked Widget', $item->title);
        $this->assertEquals(12.5, $item->price);
        $this->assertEquals(1, $item->quantity);
        $this->assertEquals($product->id, $item->product_id);
    }

    /**
     * testPriceFollowsProductUnlessOverridden checks the manual price trigger decides which price is saved.
     */
    public function testPriceFollowsProductUnlessOverridden()
    {
        $product = $this->makeProduct('Priced Widget', 10);

        $item = $this->makeItem($product, ['price' => 99]);
        $this->assertEquals(10, $item->fresh()->price);

        $item = $this->makeItem($product, ['price' => 99, 'quantity' => 2, 'is_price_override' => true]);
        $this->assertEquals(99, $item->fresh()->price);
        $this->assertEquals(198, $item->fresh()->total);
    }

    /**
     * testItemsAreDeletedWithOrder checks the hasMany delete option removes the order lines.
     */
    public function testItemsAreDeletedWithOrder()
    {
        $item = $this->makeItem($this->makeProduct('Deleted Widget', 5));
        $order = $item->order;

        $order->delete();

        $this->assertNull(OrderItem::find($item->id));
    }

    /**
     * testPickedProductPrefillsNewItem checks the controller fills the item form from the posted product_id.
     */
    public function testPickedProductPrefillsNewItem()
    {
        $product = $this->makeProduct('Posted Widget', 7.25);

        request()->setMethod('POST');
        request()->request->replace(['product_id' => $product->id]);

        $controller = new Orders;
        $widget = new Form($controller, ['model' => new OrderItem, 'fields' => []]);
        $controller->relationExtendManageFormWidget($widget, 'items', new Order);

        $this->assertEquals('Posted Widget', $widget->getModel()->title);
        $this->assertEquals(7.25, $widget->getModel()->price);
    }

    /**
     * testPickedProductDoesNotRefillExistingItem checks the controller leaves an existing item alone when a product_id is posted.
     */
    public function testPickedProductDoesNotRefillExistingItem()
    {
        $item = $this->makeItem($this->makeProduct('Original Widget', 5), ['title' => 'Renamed line']);
        $otherProduct = $this->makeProduct('Other Widget', 9);

        request()->setMethod('POST');
        request()->request->replace(['product_id' => $otherProduct->id]);

        $controller = new Orders;
        $widget = new Form($controller, ['model' => $item->fresh(), 'fields' => []]);
        $controller->relationExtendManageFormWidget($widget, 'items', $item->order);

        $this->assertEquals('Renamed line', $widget->getModel()->title);
        $this->assertEquals(5, $widget->getModel()->price);
        $this->assertEquals($item->product_id, $widget->getModel()->product_id);
    }

    /**
     * testItemKeepsSoftDeletedProduct checks the withTrashed scope on the product relation still resolves a deleted product.
     */
    public function testItemKeepsSoftDeletedProduct()
    {
        $item = $this->makeItem($this->makeProduct('Retired Widget', 3));
        $item->product->delete();

        $product = OrderItem::find($item->id)->product;

        $this->assertNotNull($product);
        $this->assertTrue($product->trashed());
        $this->assertEquals('Retired Widget', $product->title);
    }

    /**
     * makeProduct creates a product with a price.
     */
    protected function makeProduct(string $title, float $price): Product
    {
        $product = new Product;
        $product->title = $title;
        $product->price = $price;
        $product->save();

        return $product;
    }

    /**
     * makeItem creates an order with one item for the product.
     */
    protected function makeItem(Product $product, array $attributes = []): OrderItem
    {
        $order = Order::create(['title' => 'Test Order']);

        $item = new OrderItem;
        $item->fillFromProduct($product);
        $item->order = $order;

        foreach ($attributes as $key => $value) {
            $item->{$key} = $value;
        }

        $item->save();

        return $item;
    }
}
