<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Country;
use October\Test\Models\Category;

/**
 * ModelTraitTest checks the behaviour that model traits add, such as a single default record and an automatic sort order.
 */
class ModelTraitTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * setUp clears the default country cached by the Defaultable trait, since the cache is static and outlives the test transaction.
     */
    public function setUp(): void
    {
        parent::setUp();

        Country::clearDefaultableCache();
    }

    /**
     * tearDown clears the default country cached during the test, so later tests never read a rolled back record.
     */
    public function tearDown(): void
    {
        Country::clearDefaultableCache();

        parent::tearDown();
    }

    /**
     * testCountryKeepsOneDefault checks saving a second default country clears the default flag on the first.
     */
    public function testCountryKeepsOneDefault()
    {
        $first = $this->makeCountry('First Default', 'FD');
        $second = $this->makeCountry('Second Default', 'SD');

        $this->assertFalse((bool) Country::find($first->id)->is_default);
        $this->assertTrue((bool) Country::find($second->id)->is_default);
        $this->assertSame(1, Country::where('is_default', true)->count());
        $this->assertEquals($second->id, Country::getDefault()->id);
    }

    /**
     * testCountryGetDefaultPromotesFirstCountry checks getDefault makes the first country the default when no country is the default.
     */
    public function testCountryGetDefaultPromotesFirstCountry()
    {
        Country::query()->update(['is_default' => false]);

        $default = Country::getDefault();

        $this->assertEquals(Country::first()->id, $default->id);
        $this->assertTrue((bool) Country::find($default->id)->is_default);
        $this->assertSame(1, Country::where('is_default', true)->count());
    }

    /**
     * testCategorySortOrderIsSetOnCreate checks the Sortable trait gives a new category a sort order, which needs the Multisite trait to set site_root_id first.
     */
    public function testCategorySortOrderIsSetOnCreate()
    {
        $category = new Category;
        $category->name = 'Sorted Category';
        $category->save();

        $this->assertEquals($category->id, Category::find($category->id)->sort_order);
    }

    /**
     * makeCountry saves a country flagged as the default.
     */
    protected function makeCountry(string $name, string $code): Country
    {
        $country = new Country;
        $country->name = $name;
        $country->code = $code;
        $country->is_default = true;
        $country->save();

        return $country;
    }
}
