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
     * @todo need to make sure the first user can be saved, validation fails by default
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
                ->scrollIntoView('.form-buttons')
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

            $browser
                ->type('User[username]', 'Dusk Test')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Photo field is required PHOTO.')
                ->click('a.flash-close')
                ->waitFor('a[href="#secondarytab-single-image"].active')
            ;

            // Upload photo
            $browser
                ->attach('#FileUpload-formPhoto-photo .dz-hidden-input', __DIR__.'/../../fixtures/sample-image.jpg')
                ->waitForTextIn('#FileUpload-formPhoto-photo .upload-files-container .upload-object h4.filename', 'sample-image.jpg')
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Portfolio field is WOW required.')
                ->click('a.flash-close')
                ->waitFor('a[href="#secondarytab-multi-image"].active')
            ;

            // Upload portfolio
            $browser
                ->attach('#FileUpload-formPortfolio-portfolio .dz-hidden-input', __DIR__.'/../../fixtures/sample-image.jpg')
                ->waitForTextIn('#FileUpload-formPortfolio-portfolio .upload-files-container .upload-object:nth-child(1) h4.filename', 'sample-image.jpg')
                ->pause(300)
                ->attach('#FileUpload-formPortfolio-portfolio .dz-hidden-input', __DIR__.'/../../fixtures/sample-long.jpg')
                ->waitForTextIn('#FileUpload-formPortfolio-portfolio .upload-files-container .upload-object:nth-child(2) h4.filename', 'sample-long.jpg')
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Roles field is WOW required.')
                ->click('a.flash-close')
            ;

            // Attach a role
            $browser
                ->click('a[href="#primarytab-standard"]')
                ->waitFor('a[href="#primarytab-standard"].active')
                ->click('#Users-create-RelationController-roles-toolbar [data-handler=onRelationButtonAdd]')
                ->waitForTextIn('.modal-title', 'Manage Roles')
                ->pause(300)
                ->check('#Lists-relationRolesManageList table tbody tr:nth-child(1) input.form-check-input')
                ->click('.modal-footer [data-request=onRelationManageAdd]')
                ->waitForTextIn('.oc-flash-message.success', 'Role Added')
                ->click('a.flash-close')
            ;

            $browser
                ->ajaxRequest('.form-buttons [type=submit][data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'User Created')
                ->click('a.flash-close')
            ;

            // Delete a photo to retest validation
            $browser
                ->click('a[href="#secondarytab-single-image"]')
                ->waitFor('a[href="#secondarytab-single-image"].active')
                ->click('#FileUpload-formPhoto-photo .toolbar-clear-file')
                ->waitForTextIn('.modal-body > p', 'Are you sure?')
                ->press('OK')
                ->waitUntilMissing('#FileUpload-formPhoto-photo .upload-files-container .upload-object')
                ->scrollIntoView('.form-buttons')
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Photo field is required PHOTO.')
                ->click('a.flash-close')
            ;

            // Delete record
            $browser
                ->ajaxRequest('.form-buttons [data-request=onDelete]')
                ->waitForTextIn('.modal-body > p', 'Do you really want to delete this user?')
                ->press('OK')
            ;

            $browser
                ->waitForLocation('/admin/october/test/users')
                ->waitForTextIn('.oc-flash-message.success', 'User Deleted')
                ->click('a.flash-close')
            ;
        });
    }
}
