<?php

/**
 * ReviewsTest
 */
class ReviewsTest extends BrowserTestCase
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
     * testReviewsIndex
     */
    public function testReviewsIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/reviews')
                ->assertTitleContains('Manage Reviews |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/reviews/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Review |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Review Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testReviewsCreate
     */
    public function testReviewsCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/reviews')
                ->assertTitleContains('Manage Reviews |');

            $browser
                ->clickLink('New Review')
                ->waitForLocation('/admin/october/test/reviews/create')
                ->waitForEvent('page:load', 'document')
            ;

            $browser
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Feature Color field is required.')
                ->click('a.flash-close')
            ;
        });
    }
}
