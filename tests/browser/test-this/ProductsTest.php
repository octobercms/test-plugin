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
