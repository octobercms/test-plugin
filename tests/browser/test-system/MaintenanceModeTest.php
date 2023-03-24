<?php

/**
 * MaintenanceModeTest
 */
class MaintenanceModeTest extends BrowserTestCase
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
     * testSetMaintenanceMode
     */
    public function testSetMaintenanceModeSetOnOff()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/system/settings/update/october/cms/maintenance_settings?_site_id=1')
                ->assertTitleContains('Maintenance Mode |')
            ;

            // Reset to default
            $browser
                ->click('.form-buttons [data-request=onResetDefault]')
                ->waitForTextIn('.modal-body > p', 'Are you sure?')
                ->press('OK')
                ->waitForTextIn('.oc-flash-message.success', 'Reset Complete')
                ->click('a.flash-close')
            ;

            // Turn on
            $browser
                ->check('#Form-field-MaintenanceSetting-is_enabled')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Maintenance Mode settings updated')
                ->click('a.flash-close')
            ;

            $browser
                ->visit('/admin/system/settings/update/october/cms/maintenance_settings')
                ->assertTitleContains('Maintenance Mode |')
                ->assertChecked('#Form-field-MaintenanceSetting-is_enabled')
            ;

            // Turn off
            $browser
                ->uncheck('#Form-field-MaintenanceSetting-is_enabled')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Maintenance Mode settings updated')
                ->click('a.flash-close')
            ;

            $browser
                ->visit('/admin/system/settings/update/october/cms/maintenance_settings?_site_id=1')
                ->assertTitleContains('Maintenance Mode |')
                ->assertNotChecked('#Form-field-MaintenanceSetting-is_enabled')
            ;

            // Reset to default
            $browser
                ->click('.form-buttons [data-request=onResetDefault]')
                ->waitForTextIn('.modal-body > p', 'Are you sure?')
                ->press('OK')
                ->waitForTextIn('.oc-flash-message.success', 'Reset Complete')
                ->click('a.flash-close')
            ;
        });
    }

    /**
     * testSetMaintenanceModeReset
     */
    public function testSetMaintenanceModeReset()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/system/settings/update/october/cms/maintenance_settings?_site_id=1')
                ->assertTitleContains('Maintenance Mode |')
            ;

            // Turn on
            $browser
                ->check('#Form-field-MaintenanceSetting-is_enabled')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Maintenance Mode settings updated')
                ->click('a.flash-close')
            ;

            $browser
                ->visit('/admin/system/settings/update/october/cms/maintenance_settings')
                ->assertTitleContains('Maintenance Mode |')
                ->assertChecked('#Form-field-MaintenanceSetting-is_enabled')
            ;

            // Reset to default
            $browser
                ->click('.form-buttons [data-request=onResetDefault]')
                ->waitForTextIn('.modal-body > p', 'Are you sure?')
                ->press('OK')
                ->waitForTextIn('.oc-flash-message.success', 'Reset Complete')
                ->click('a.flash-close')
            ;

            // Check that the reset worked
            $browser
                ->visit('/admin/system/settings/update/october/cms/maintenance_settings?_site_id=1')
                ->assertTitleContains('Maintenance Mode |')
                ->assertNotChecked('#Form-field-MaintenanceSetting-is_enabled')
            ;
        });
    }
}
