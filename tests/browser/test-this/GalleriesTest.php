<?php

/**
 * GalleriesTest
 */
class GalleriesTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testGalleriesIndex
     */
    public function testGalleriesIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

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
                ->waitForTextIn('.oc-flash-message', 'Gallery Updated')
                ->click('a.flash-close');
        });
    }
}
