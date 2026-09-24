<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\FormWidgets\DataTable;
use October\Test\Models\Order;

/**
 * DataTableFieldTest validates the datatable form field, both as a top-level
 * tab field and when nested inside a repeater and a builder-style repeater.
 */
class DataTableFieldTest extends PluginTestCase
{
    /**
     * setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->migrateDatabase();
    }

    /**
     * testTopLevelDataTableRoundTrip verifies a top-level datatable field
     * stores and reloads its rows through the jsonable attribute.
     */
    public function testTopLevelDataTableRoundTrip()
    {
        $rows = [
            ['sku' => 'A-1', 'description' => 'Widget', 'quantity' => 2, 'unit_price' => 9.5, 'taxable' => 1],
            ['sku' => 'B-2', 'description' => 'Gadget', 'quantity' => 1, 'unit_price' => 19.0, 'taxable' => 0],
        ];

        $order = Order::create(['title' => 'Line Item Order', 'line_items' => $rows]);

        $found = Order::find($order->id);
        $this->assertIsArray($found->line_items);
        $this->assertCount(2, $found->line_items);
        $this->assertEquals('A-1', $found->line_items[0]['sku']);
        $this->assertEquals('Gadget', $found->line_items[1]['description']);
    }

    /**
     * testDataTableInRepeaterRoundTrip verifies a datatable nested inside a
     * plain repeater stores and reloads its rows per repeater item.
     */
    public function testDataTableInRepeaterRoundTrip()
    {
        $blocks = [
            [
                'heading' => 'Dimensions',
                'rows' => [
                    ['label' => 'Width', 'value' => '10cm'],
                    ['label' => 'Height', 'value' => '20cm'],
                ],
            ],
            [
                'heading' => 'Weight',
                'rows' => [
                    ['label' => 'Net', 'value' => '1kg'],
                ],
            ],
        ];

        $order = Order::create(['title' => 'Repeater Order', 'blocks' => $blocks]);

        $found = Order::find($order->id);
        $this->assertCount(2, $found->blocks);
        $this->assertCount(2, $found->blocks[0]['rows']);
        $this->assertEquals('Width', $found->blocks[0]['rows'][0]['label']);
        $this->assertEquals('1kg', $found->blocks[1]['rows'][0]['value']);
    }

    /**
     * testDataTableInBuilderRoundTrip verifies a datatable nested inside a
     * builder-style repeater (groups) preserves the group type and rows.
     */
    public function testDataTableInBuilderRoundTrip()
    {
        $groups = [
            [
                '_group' => 'spec_table',
                'specs' => [
                    ['attribute' => 'Color', 'detail' => 'Red'],
                    ['attribute' => 'Material', 'detail' => 'Steel'],
                ],
            ],
            [
                '_group' => 'pricing_table',
                'tiers' => [
                    ['tier' => 'Bronze', 'price' => 10],
                    ['tier' => 'Gold', 'price' => 50],
                ],
            ],
        ];

        $order = Order::create(['title' => 'Builder Order', 'block_groups' => $groups]);

        $found = Order::find($order->id);
        $this->assertCount(2, $found->block_groups);
        $this->assertEquals('spec_table', $found->block_groups[0]['_group']);
        $this->assertEquals('Red', $found->block_groups[0]['specs'][0]['detail']);
        $this->assertEquals('pricing_table', $found->block_groups[1]['_group']);
        $this->assertEquals(50, $found->block_groups[1]['tiers'][1]['price']);
    }

    /**
     * testEmptyDataTableSavesEmptyArray verifies an untouched datatable field
     * persists as an empty array rather than null.
     */
    public function testEmptyDataTableSavesEmptyArray()
    {
        $order = Order::create(['title' => 'Empty Order', 'line_items' => []]);

        $found = Order::find($order->id);
        $this->assertIsArray($found->line_items);
        $this->assertEmpty($found->line_items);
    }

    /**
     * testWidgetGetSaveValueDecodesJson verifies the DataTable widget decodes
     * the JSON string posted by the client into a rows array.
     */
    public function testWidgetGetSaveValueDecodesJson()
    {
        $widget = $this->makeDataTableWidget();

        $posted = json_encode([
            ['sku' => 'A-1', 'quantity' => 3],
        ]);

        $value = $widget->getSaveValue($posted);
        $this->assertIsArray($value);
        $this->assertEquals('A-1', $value[0]['sku']);
        $this->assertEquals(3, $value[0]['quantity']);
    }

    /**
     * testWidgetGetSaveValueHandlesEmpty verifies invalid or empty client
     * input decodes to an empty array.
     */
    public function testWidgetGetSaveValueHandlesEmpty()
    {
        $widget = $this->makeDataTableWidget();

        $this->assertEquals([], $widget->getSaveValue(''));
        $this->assertEquals([], $widget->getSaveValue('null'));
    }

    /**
     * makeDataTableWidget builds a DataTable widget bound to the line_items
     * field of the Order form.
     */
    protected function makeDataTableWidget(): DataTable
    {
        $controller = new \October\Test\Controllers\Orders;

        $form = new \Backend\Widgets\Form($controller, [
            'model' => new Order,
            'arrayName' => 'Order',
            'fields' => [
                'line_items' => [
                    'type' => 'datatable',
                    'columns' => [
                        'sku' => ['type' => 'string', 'title' => 'SKU'],
                        'quantity' => ['type' => 'numeric', 'title' => 'Qty'],
                    ],
                ],
            ],
        ]);

        $form->bindToController();

        return $form->getFormWidget('line_items');
    }
}
