<?php

/**
 * PostsTest
 */
class PostsTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;

    /**
     * testPostsIndex
     */
    public function testPostsIndex()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

            $browser
                ->visit('/admin/october/test/posts')
                ->assertTitleContains('Manage Posts |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/posts/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Posts (Awesome Title) |');

            $browser
                ->pause(300)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message', 'Post Updated')
                ->click('a.flash-close');
        });
    }
}
