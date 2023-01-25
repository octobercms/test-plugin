<?php

/**
 * ProductsTest
 */
class ProductsTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testProductsIndex
     */
    public function testProductsIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

            $browser
                ->visit('/admin/october/test/products')
                ->assertTitleContains('Manage Products |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/products/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Product |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message', 'Product Updated')
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
                ->waitForTextIn('.oc-flash-message', 'Product Category Updated')
                ->click('a.flash-close');
        });
    }
}
