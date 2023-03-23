<?php

/**
 * UsersTest
 */
class UsersTest extends BrowserTestCase
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
     * testUsersIndex
     */
    public function testUsersIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/users')
                ->assertTitleContains('Manage Users |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/users/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Users |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'User Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testUsersCreate
     */
    public function testUsersCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/users')
                ->assertTitleContains('Manage Users |');

            $browser
                ->clickLink('New User')
                ->waitForLocation('/admin/october/test/users/create')
                ->waitForEvent('page:load', 'document')
            ;

            $browser
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Username field is WOW required.')
                ->click('a.flash-close')
            ;
        });
    }
}
