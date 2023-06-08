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
                ->click('#RecordFinder-formNotesForm0Person-person .toolbar-find-button')
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
                ->click('.list-cell-index-3')
                ->waitForTextIn('.recordname', 'Lara Croft')
                ->pause(300)
                ->click('#RecordFinder-formNotesForm0Person-person .find-remove-button')
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

    /**
     * testCitiesCreate
     */
    public function testCitiesCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/cities')
                ->assertTitleContains('Manage Cities |')
            ;

            $browser
                ->clickLink('New City')
                ->waitForLocation('/admin/october/test/cities/create')
                ->waitForEvent('page:load', 'document')
            ;

            $browser
                ->type('City[name]', 'Dusk Test')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Country field is required.')
                ->click('a.flash-close')
            ;

            $browser
                ->clickLink('Country')
                ->waitForTextIn('#Form-field-City-country-group', 'Country')
            ;

            $browser
                ->clickLink('Link Country')
                ->waitForTextIn('#Lists-relationCountryManageList .list-cell-index-1', 'Petoria')
                ->pause(300)
                ->click('.list-cell-index-1')
                ->waitForTextIn('.oc-flash-message.success', 'Country Linked')
                ->click('a.flash-close')
                ->waitForTextIn('#Form-relationCountryViewForm-field-Country-name-group', 'Petoria')
            ;

            $browser
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'City Created')
                ->click('a.flash-close')
            ;

            $browser
                ->ajaxRequest('.form-buttons [data-request=onDelete]')
                ->waitForTextIn('.modal-body > p', 'Delete this city?')
                ->press('OK')
            ;

            $browser
                ->waitForLocation('/admin/october/test/cities')
                ->waitForTextIn('.oc-flash-message.success', 'City Deleted')
                ->click('a.flash-close')
            ;
        });
    }
}
