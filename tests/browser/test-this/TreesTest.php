<?php

/**
 * TreesTest
 */
class TreesTest extends BrowserTestCase
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
     * testMembersIndex
     */
    public function testMembersIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/trees')
                ->assertTitleContains('Manage Members |');

            $browser
                ->click('#ListStructure-members .list-cell-index-1')
                ->waitForLocation('/admin/october/test/members/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Member |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Member Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testCategoriesIndex
     */
    public function testCategoriesIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/trees')
                ->assertTitleContains('Manage Members |');

            $browser
                ->click('#ListStructure-categories .list-cell-index-1')
                ->waitForLocation('/admin/october/test/categories/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Category |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Category Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testChannelsIndex
     */
    public function testChannelsIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/trees')
                ->assertTitleContains('Manage Members |');

            $browser
                ->click('#ListStructure-channels .list-cell-index-1')
                ->waitForLocation('/admin/october/test/channels/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Channel |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Channel Updated')
                ->click('a.flash-close');
        });
    }
}
