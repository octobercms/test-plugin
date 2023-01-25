<?php

/**
 * ReviewsTest
 */
class ReviewsTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testReviewsIndex
     */
    public function testReviewsIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

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
                ->waitForTextIn('.oc-flash-message', 'Review Updated')
                ->click('a.flash-close');
        });
    }
}
