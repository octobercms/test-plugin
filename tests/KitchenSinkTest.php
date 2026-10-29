<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Components\KitchenSink;

/**
 * KitchenSinkTest checks the KitchenSink component's dynamic Inspector options.
 */
class KitchenSinkTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testHandleOptionsDependOnType resolves options through the same lookup the Inspector uses.
     */
    public function testHandleOptionsDependOnType()
    {
        $this->assertEquals(['paradise', 'nirvana'], $this->getInspectorOptionValues('handle', ['type' => 'collection']));
        $this->assertEquals(['boring', 'kirby'], $this->getInspectorOptionValues('handle', ['type' => 'entry']));
    }

    /**
     * getInspectorOptionValues calls InspectableContainer with the posted values the Inspector sends.
     */
    protected function getInspectorOptionValues(string $property, array $values): array
    {
        request()->setMethod('POST');
        request()->request->replace([
            'inspectorProperty' => $property,
            'inspectorClassName' => KitchenSink::class,
        ] + $values);

        $container = new class {
            use \Backend\Traits\InspectableContainer;

            /**
             * flushAssets does nothing, since this container has no assets to stop broadcasting.
             */
            public function flushAssets()
            {
            }
        };

        return array_column($container->onInspectableGetOptions()['options'], 'value');
    }
}
