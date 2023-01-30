<?php

/**
 * GalleriesTest
 */
class GalleriesTest extends BrowserTestCase
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
     * testGalleriesIndex
     */
    public function testGalleriesIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/galleries')
                ->assertTitleContains('Manage Galleries |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/galleries/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Gallery |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Gallery Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testGalleriesCreate
     */
    public function testGalleriesCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/galleries')
                ->assertTitleContains('Manage Galleries |');

            $browser
                ->clickLink('New Gallery')
                ->waitForLocation('/admin/october/test/galleries/create')
                ->waitForEvent('page:load', 'document')
            ;

            // Checking default value on balloon selector
            $browser
                ->waitFor('#Form-field-Gallery-status li[data-value="draft"].active')
            ;

            $browser
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Title field is required.')
                ->click('a.flash-close')
            ;
        });
    }
}
