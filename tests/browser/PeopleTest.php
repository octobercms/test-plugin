<?php

/**
 * PeopleTest
 */
class PeopleTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testPeopleIndex
     */
    public function testPeopleIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

            $browser
                ->visit('/admin/october/test/people')
                ->assertTitleContains('Manage Peoples |');

            $browser
                ->clickLink('Show Error Message')
                ->waitForDialog()
                ->assertDialogOpened('This message came from a smart error 406.')
                ->acceptDialog();

            $browser
                ->clickLink('Send Test Email')
                ->waitForTextIn('.oc-flash-message', 'Done')
                ->click('a.flash-close');

            $browser
                ->clickLink('Show Data Table')
                ->waitForTextIn('.modal-title', 'Data Table In Modal')
                ->pause(300)
                ->press('.modal-header .btn-close');

            $browser
                ->clickLink('Show Modal Popup')
                ->waitForTextIn('.modal-title', 'Test')
                ->pause(300)
                ->press('With confirm')
                ->waitForTextIn('.modal-body > p', 'Test')
                ->press('OK')
                ->waitForTextIn('.oc-flash-message', 'All good')
                ->click('a.flash-close');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/people/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit People |');

            $browser
                ->click('[data-request=onSave]')
                ->waitForTextIn('.oc-flash-message', 'Person Updated')
                ->click('a.flash-close');
        });
    }
}
