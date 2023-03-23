<?php namespace October\Test\Tests\Browser\Concerns;

/**
 * InteractsWithAuth
 */
trait InteractsWithAuth
{
    /**
     * loginToBrowser
     */
    public function loginToBrowser($browser)
    {
        $browser
            ->visit('/admin')
            ->waitForLocation('/admin/backend/auth/signin')
            ->assertTitleContains('Administration Area |')
            ->type('login', env('DUSK_ADMIN_USER', 'admin'))
            ->type('password', env('DUSK_ADMIN_PASS', 'admin'))
            ->check('remember')
            ->press('Login')
            ->waitForLocation('/admin');
    }
}
