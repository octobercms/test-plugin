<?php

/**
 * ThemesTest
 */
class ThemesTest extends BrowserTestCase
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
     * testCreateDeleteTheme
     */
    public function testCreateDeleteTheme()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/cms/themes')
                ->assertTitleContains('Frontend Theme |')
            ;

            // Create theme
            $browser
                ->clickLink('Create a New Blank Theme')
                ->waitForTextIn('.modal-title', 'Create Theme')
                ->pause(300);

            $browser
                ->type('Theme[name]', 'Dusk Test Theme')
                ->type('Theme[dir_name]', 'dusk-test-theme')
                ->press('Create')
                ->waitForTextIn('.oc-flash-message.success', 'Theme Created!')
                ->click('a.flash-close')
            ;

            // Select this theme
            $browser
                ->scrollIntoView('#themeListItem-dusk-test-theme')
                ->pause(300)
                ->click('#themeListItem-dusk-test-theme button[data-request="onSetActiveTheme"]')
                ->waitFor('#themeListItem-dusk-test-theme.active')
            ;

            // Select demo theme
            $browser->click('#themeListItem-demo button[data-request="onSetActiveTheme"]')
                ->waitFor('#themeListItem-demo.active')
            ;

            // Delete theme
            $browser
                ->click('#themeListItem-dusk-test-theme button.btn-secondary')
                ->clickLink('Delete')
                ->waitForTextIn('.modal-body > p', 'Delete this theme? It cannot be undone!')
                ->press('OK')
                ->waitForTextIn('.oc-flash-message.success', 'Theme deleted!')
                ->click('a.flash-close')
                ->waitUntilMissing('#themeListItem-dusk-test-theme')
            ;
        });
    }
}
