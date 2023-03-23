<?php

/**
 * PagesTest
 */
class PagesTest extends BrowserTestCase
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
     * testPagesIndex
     */
    public function testPagesIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/pages')
                ->assertTitleContains('Manage Pages |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/pages/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Page |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Page Updated')
                ->click('a.flash-close');
        });
    }
}
