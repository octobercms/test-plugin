<?php

/**
 * AuthenticationTest
 */
class AuthenticationTest extends BrowserTestCase
{
    /**
     * testAuthentication
     */
    public function testAuthentication()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin')
                ->waitForLocation('/admin/backend/auth/signin')
                ->assertTitleContains('Administration Area |')
                ->type('login', env('DUSK_ADMIN_USER', 'admin'))
                ->type('password', env('DUSK_ADMIN_PASS', 'admin'))
                ->check('remember')
                ->press('Login');

            $browser
                ->waitForLocation('/admin')
                ->assertTitleContains('Dashboard |')
                ->click('#layout-mainmenu .mainmenu-account > a')
                ->clickLink('Sign Out');

            $browser
                ->waitForLocation('/admin/backend/auth/signin')
                ->assertTitleContains('Administration Area |');
        });
    }
}
