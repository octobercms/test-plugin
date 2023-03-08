<?php

/**
 * LocationsTest
 */
class LocationsTest extends BrowserTestCase
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
     * testLocationsIndex
     */
    public function testLocationsIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/locations')
                ->assertTitleContains('Manage Locations |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/locations/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Location |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Location Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testCountriesIndex
     */
    public function testCountriesIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/countries')
                ->assertTitleContains('Manage Countries |')
            ;

            $browser
                ->click('.list-cell-index-2')
                ->waitForLocation('/admin/october/test/countries/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Countries |')
            ;

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Country Updated')
                ->click('a.flash-close')
            ;
        });
    }

    /**
     * testRecordFinderInRepeater
     */
    public function testRecordFinderInRepeater()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/countries/update/1')
                ->assertTitleContains('Edit Countries |')
            ;

            $browser
                ->click('a[href="#primarytab-notes"]')
                ->pause(300)
                ->click('a[href="#secondarytab-additional-information"]')
                ->pause(300)
                ->click('button[data-handler="formNotesForm0Person::onFindRecord"]')
                ->waitForTextIn('.modal-title', 'Find Record')
            ;

            $browser
                ->click('#Lists-formNotesForm0PersonList .list-cell-name-id a')
                ->waitUntilMissing('html[data-ajax-progress]')
                ->pause(300)
                ->waitFor('#Lists-formNotesForm0PersonList .list-cell-name-id.active a')
            ;

            $browser
                ->click('#Lists-formNotesForm0PersonList .list-cell-name-bio a')
                ->waitUntilMissing('html[data-ajax-progress]')
                ->pause(300)
                ->waitFor('#Lists-formNotesForm0PersonList .list-cell-name-bio.active a')
            ;

            $browser
                ->type('formNotesForm0PersonSearch[term]', 'Lara Croft')
                ->waitForTextIn('#Lists-formNotesForm0PersonList .list-cell-index-2 span', 'Lara Croft')
                ->click('.list-cell-index-1')
                ->waitForTextIn('.recordname', 'Lara Croft')
                ->click('.find-remove-button')
                ->waitForTextIn('.modal-body > p', 'Are you sure?')
                ->press('OK')
            ;

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Country Updated')
                ->click('a.flash-close')
            ;
        });
    }

    /**
     * testCitiesIndex
     */
    public function testCitiesIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/cities')
                ->assertTitleContains('Manage Cities |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/cities/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit City |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'City Updated')
                ->click('a.flash-close');
        });
    }
}
