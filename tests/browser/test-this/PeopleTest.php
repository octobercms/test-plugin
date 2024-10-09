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

            // Test Lazy Loaded tab
            $browser
                ->clickLink('Activities')
                ->waitForTextIn('#Form-field-Person-hobbies-group', 'Hobbies')
            ;

            // Test Record Finder
            $browser
                ->waitForTextIn('#RecordFinder-formAltPhone-alt_phone .recordname', 'Home')
                ->click('#RecordFinder-formAltPhone-alt_phone .find-remove-button')
                ->waitForTextIn('.modal-body > p', 'Are you sure?')
                ->press('OK')
            ;

            $browser
                ->click('button[data-handler="formAltPhone::onFindRecord"]')
                ->waitForTextIn('.modal-title', 'Please pick an alternative phone')
            ;

            $browser
                ->click('#Lists-formAltPhoneList .list-cell-name-id a')
                ->waitUntilMissing('html[data-ajax-progress]')
                ->pause(300)
                ->waitFor('#Lists-formAltPhoneList .list-cell-name-id.active a')
            ;

            $browser
                ->type('formAltPhoneSearch[term]', 'Home')
                ->waitForTextIn('#Lists-formAltPhoneList .list-cell-index-2', 'Home')
                ->click('.list-cell-index-1')
                ->waitForTextIn('#RecordFinder-formAltPhone-alt_phone .recordname', 'Home')
            ;

            $browser
                ->pause(300)
                ->scrollIntoView('.form-buttons')
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
                ->scrollIntoView('.form-buttons')
                ->pause(300)
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
