<?php

/**
 * LocationsTest
 */
class LocationsTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testLocationsIndex
     */
    public function testLocationsIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

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
                ->waitForTextIn('.oc-flash-message', 'Location Updated')
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
                ->assertTitleContains('Manage Countries |');

            $browser
                ->click('.list-cell-index-2')
                ->waitForLocation('/admin/october/test/countries/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Countries |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message', 'Country Updated')
                ->click('a.flash-close');
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
                ->waitForTextIn('.oc-flash-message', 'City Updated')
                ->click('a.flash-close');
        });
    }
}
