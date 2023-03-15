<?php

/**
 * ProductsTest
 */
class ProductsTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testBrowserLogin
     */
    public function testBrowserLogin()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);
        });
    }

    /**
     * testProductsIndex
     */
    public function testProductsIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/products?_site_id=1')
                ->assertTitleContains('Manage Products |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/products/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Product |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Product Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testProductCategoriesIndex
     */
    public function testProductCategoriesIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/productcategories')
                ->assertTitleContains('Manage Product Categories |');

            // Reset List
            $browser
                ->click('#ListStructure .list-setup > a')
                ->waitForTextIn('.modal-title', 'List Setup')
                ->pause(300)
                ->press('Reset to Default')
                ->waitUntilMissing('[data-request="list::onResetSetup"]')
            ;

            // Expanding and collapsing tree
            $browser
                ->click('[data-tree-id="7"] a.tree-expand-collapse.is-expanded')
                ->waitUntilMissing('[data-tree-id="11"]')
            ;

            $browser
                ->click('[data-tree-id="7"] a.tree-expand-collapse')
                ->waitFor('[data-tree-id="11"]')
            ;

            // Sorting and paging list
            $browser
                ->click('#ListStructure .list-cell-name-name a')
                ->waitUntilMissing('html[data-ajax-progress]')
                ->pause(300)
                ->waitFor('#ListStructure .list-cell-name-name.active a')
            ;

            $browser
                ->waitForTextIn('#ListStructure .list-cell-index-1', 'Vegetables')
                ->click('#ListStructure .list-pagination-links .page-link.page-next')
                ->waitForTextIn('#ListStructure .list-cell-index-1', 'Perfume')
                ->click('#ListStructure .list-pagination-links .page-link.page-back')
                ->waitForTextIn('#ListStructure .list-cell-index-1', 'Vegetables')
                ->click('#ListStructure .list-cell-name-name a')
                ->waitForTextIn('#ListStructure .list-cell-index-1', 'Automotive')
                ->click('#ListStructure .list-cell-name-name a')
                ->waitFor('#ListStructure .no-pagination')
            ;

            // Searching and paging list
            $browser
                ->type('listToolbarSearch[term]', 'a ')
                ->waitForTextIn('#ListStructure .list-cell-index-1', 'Mains')
                ->click('#ListStructure .list-pagination-links .page-link.page-next')
                ->waitForTextIn('#ListStructure .list-cell-index-1', 'Hats')
                ->click('#Search-listToolbarSearch .clear-input-text')
                ->waitFor('#ListStructure .no-pagination')
            ;

            // Update record
            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/productcategories/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Product Category |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Product Category Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testProductCategoriesCreate
     */
    public function testProductCategoriesCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/productcategories')
                ->assertTitleContains('Manage Product Categories |')
            ;

            $browser
                ->clickLink('New Product Category')
                ->waitForLocation('/admin/october/test/productcategories/create')
                ->waitForEvent('page:load', 'document')
            ;

            $browser
                ->type('ProductCategory[name]', 'Dusk Test')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Product Category Created')
                ->click('a.flash-close')
            ;

            $browser
                ->ajaxRequest('.form-buttons [data-request=onDelete]')
                ->waitForTextIn('.modal-body > p', 'Delete record?')
                ->press('OK')
            ;

            $browser
                ->waitForLocation('/admin/october/test/productcategories')
                ->waitForTextIn('.oc-flash-message.success', 'Product Category Deleted')
                ->click('a.flash-close')
            ;
        });
    }
}
