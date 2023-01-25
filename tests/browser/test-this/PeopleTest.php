<?php

/**
 * PeopleTest
 */
class PeopleTest extends BrowserTestCase
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
     * testPeopleIndex
     */
    public function testPeopleIndex()
    {
        $this->browse(function($browser) {
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
                ->waitForTextIn('.oc-flash-message.success', 'Done')
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
                ->waitForTextIn('.oc-flash-message.success', 'All good')
                ->click('a.flash-close');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/people/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit People |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Person Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testPeopleCreate
     */
    public function testPeopleCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/people')
                ->assertTitleContains('Manage Peoples |')
            ;

            $browser
                ->clickLink('New Person')
                ->waitForLocation('/admin/october/test/people/create')
                ->waitForEvent('page:load', 'document')
            ;

            $browser
                ->type('Person[name]', '')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Full Name field is required.')
                ->click('a.flash-close')
            ;

            $browser
                ->type('Person[name]', 'Dusk Test')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Person Created')
                ->click('a.flash-close')
            ;

            $browser
                ->ajaxRequest('.form-buttons [data-request=onDelete]')
                ->waitForTextIn('.modal-body > p', 'Do you really want to delete this person?')
                ->press('OK')
            ;

            $browser
                ->waitForLocation('/admin/october/test/people')
                ->waitForTextIn('.oc-flash-message.success', 'Person Deleted')
                ->click('a.flash-close')
            ;
        });
    }
}
