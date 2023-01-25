<?php

/**
 * UsersTest
 */
class UsersTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testUsersIndex
     */
    public function testUsersIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

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
                ->waitForTextIn('.oc-flash-message', 'User Updated')
                ->click('a.flash-close');
        });
    }
}
