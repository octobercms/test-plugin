<?php namespace October\Test\Tests;

use Yaml;
use PluginTestCase;
use Backend\Classes\FormField;
use October\Test\Models\Country;
use October\Test\Models\Product;

/**
 * FieldOptionsTest checks how model options methods resolve dropdown options.
 */
class FieldOptionsTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testDisplayModeUsesItsOwnOptions checks the display mode field does not fall back to a model method.
     */
    public function testDisplayModeUsesItsOwnOptions()
    {
        $config = Yaml::parseFile(plugins_path('october/test/models/product/fields.yaml'));
        $fieldConfig = $config['tabs']['fields']['_display_mode'];

        $field = new FormField('_display_mode', 'Display mode');
        $options = $field->getOptionsFromModel(new Product, $fieldConfig['options'] ?? null, []);

        $this->assertEquals(['full', 'summary'], array_keys($options));
    }

    /**
     * testBulkDropdownOptionsFollowBulkPricing checks the explicit options method reads the model attribute.
     */
    public function testBulkDropdownOptionsFollowBulkPricing()
    {
        $field = new FormField('dropdown_field', 'Dropdown');
        $product = new Product;

        $product->bulk_pricing = true;
        $this->assertEquals('Bulk Enabled', $field->getOptionsFromModel($product, 'getBulkDropdownOptions', [])[0]);

        $product->bulk_pricing = false;
        $this->assertEquals('Bulk Disabled', $field->getOptionsFromModel($product, 'getBulkDropdownOptions', [])[0]);
    }

    /**
     * testCountryStateOptionsListStateTitles checks the dependent state dropdown reads the chosen country's states.
     */
    public function testCountryStateOptionsListStateTitles()
    {
        $country = Country::create(['name' => 'Australia', 'code' => 'AU']);
        $country->states = [['title' => 'Victoria'], ['title' => 'Queensland']];
        $country->save();

        $options = (new Country)->getStateOptions(null, (object) ['country' => $country->id]);

        $this->assertEquals(['Victoria', 'Queensland'], $options);
    }
}
