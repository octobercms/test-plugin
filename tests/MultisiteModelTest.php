<?php namespace October\Test\Tests;

use Db;
use Site;
use PluginTestCase;
use System\Models\SiteDefinition;
use October\Rain\Database\ModelException;
use October\Test\Models\Member;
use October\Test\Models\Company;
use October\Test\Models\Product;
use October\Test\Models\ProductCategory;

/**
 * MultisiteModelTest checks the multisite models propagate their records to a second site in the same site group.
 */
class MultisiteModelTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * @var bool autoMigrateTailor migrates the Tailor blueprint tables, since propagating a product replicates its Tailor relations
     */
    protected $autoMigrateTailor = true;

    /**
     * @var SiteDefinition site is the second site that records propagate to
     */
    protected $site;

    /**
     * setUp adds a second site, since the test database only has the primary site.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->site = new SiteDefinition;
        $this->site->name = 'Second Site';
        $this->site->code = 'second';
        $this->site->is_enabled = true;
        $this->site->is_enabled_edit = true;
        $this->site->save();

        Site::resetCache();
    }

    /**
     * tearDown clears the cached site list, since the second site is rolled back with the test transaction.
     */
    public function tearDown(): void
    {
        Site::resetCache();

        parent::tearDown();
    }

    /**
     * testProductSavePropagateCopiesToOtherSite checks savePropagate creates a copy of a new product on the second site that shares its site root.
     */
    public function testProductSavePropagateCopiesToOtherSite()
    {
        $product = $this->makeProduct('Propagated Widget', 10);
        $product->savePropagate();

        $siteIds = Product::withSites()->where('site_root_id', $product->id)->pluck('site_id')->all();
        $this->assertEqualsCanonicalizing([$product->site_id, $this->site->id], $siteIds);

        $copy = $product->findForSite($this->site->id);
        $this->assertNotEquals($product->id, $copy->id);
        $this->assertEquals('Propagated Widget', $copy->title);
        $this->assertEquals(10, $copy->price);
    }

    /**
     * testProductPropagatesOnlyPropagatableAttributes checks a later savePropagate copies the propagatable price but leaves the copy's description alone.
     */
    public function testProductPropagatesOnlyPropagatableAttributes()
    {
        $product = $this->makeProduct('Repriced Widget', 10);
        $product->description = 'Original description';
        $product->savePropagate();

        $product->price = 12;
        $product->description = 'Changed on the primary site';
        $product->savePropagate();

        $copy = $product->findForSite($this->site->id);
        $this->assertEquals(12, $copy->price);
        $this->assertEquals('Original description', $copy->description);
    }

    /**
     * testProductTitleIsUniquePerSite checks the unique_site rule rejects a duplicate title on the same site and allows it on another site.
     */
    public function testProductTitleIsUniquePerSite()
    {
        $this->makeProduct('Unique Widget', 5)->save();

        try {
            $this->makeProduct('Unique Widget', 6)->save();
            $this->fail('A duplicate title on the same site should fail validation');
        }
        catch (ModelException $ex) {
            $this->assertTrue($ex->getErrors()->has('title'));
        }

        Site::withContext($this->site->id, function () {
            $this->makeProduct('Unique Widget', 7)->save();
        });

        $this->assertEquals(
            [Site::getSiteIdFromContext(), $this->site->id],
            Product::withSites()->where('title', 'Unique Widget')->orderBy('site_id')->pluck('site_id')->all()
        );
    }

    /**
     * testProductCategoriesLinkBySiteRootId checks the categories pivot stores the category's site_root_id, so each site reads its own copy of the category.
     */
    public function testProductCategoriesLinkBySiteRootId()
    {
        $category = new ProductCategory;
        $category->name = 'Shared Category';
        $category->savePropagate();
        $copy = $category->findForSite($this->site->id);

        $product = $this->makeProduct('Shared Widget', 3);
        $product->save();
        $product->categories()->attach($copy);

        $this->assertEquals(
            [$category->id],
            Db::table('october_test_products_categories')->where('product_id', $product->id)->pluck('category_id')->all()
        );

        $this->assertEquals([$category->id], Product::find($product->id)->categories->pluck('id')->all());

        $secondSiteIds = Site::withContext($this->site->id, function () use ($product) {
            return Product::withSites()->find($product->id)->categories->pluck('id')->all();
        });

        $this->assertEquals([$copy->id], $secondSiteIds);
    }

    /**
     * testMemberTreePropagatesToOtherSite checks members saved with the propagate option keep their parent link between the copies on the second site.
     */
    public function testMemberTreePropagatesToOtherSite()
    {
        $parent = new Member;
        $parent->name = 'Propagated Parent';
        $parent->save(['propagate' => true]);

        $child = new Member;
        $child->name = 'Propagated Child';
        $child->parent = $parent;
        $child->save(['propagate' => true]);

        $childCopy = $child->findForSite($this->site->id);
        $parentCopy = $parent->findForSite($this->site->id);

        $resolvedParent = Site::withContext($this->site->id, function () use ($childCopy) {
            return Member::find($childCopy->id)->parent;
        });

        $this->assertEquals($parentCopy->id, $resolvedParent->id);
        $this->assertEquals('Propagated Parent', $resolvedParent->name);
    }

    /**
     * testCompanyDeleteTrashesOtherSiteCopies checks deleting a propagated company also soft deletes its copy on the second site.
     */
    public function testCompanyDeleteTrashesOtherSiteCopies()
    {
        $company = new Company;
        $company->name = 'Propagated Company';
        $company->savePropagate();
        $this->assertSame(2, Company::withSites()->where('site_root_id', $company->id)->count());

        $company->delete();

        $this->assertSame(0, Company::withSites()->where('site_root_id', $company->id)->count());
        $this->assertSame(2, Company::withSites()->withTrashed()->where('site_root_id', $company->id)->count());
    }

    /**
     * makeProduct returns an unsaved product with a title and price.
     */
    protected function makeProduct(string $title, float $price): Product
    {
        $product = new Product;
        $product->title = $title;
        $product->price = $price;

        return $product;
    }
}
