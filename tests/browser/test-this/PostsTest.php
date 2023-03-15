<?php

/**
 * PostsTest
 */
class PostsTest extends BrowserTestCase
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
     * testPostsIndex
     */
    public function testPostsIndex()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/posts')
                ->assertTitleContains('Manage Posts |');

            $browser
                ->click('.list-cell-index-1')
                ->waitForLocation('/admin/october/test/posts/update/1')
                ->waitForEvent('page:load', 'document')
                ->assertTitleContains('Edit Posts (Awesome Title) |');

            $browser
                ->pause(600)
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Post Updated')
                ->click('a.flash-close');
        });
    }

    /**
     * testPostsCreate
     */
    public function testPostsCreate()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/october/test/posts')
                ->assertTitleContains('Manage Posts |');

            $browser
                ->clickLink('New Post')
                ->waitForLocation('/admin/october/test/posts/create')
                ->waitForEvent('page:load', 'document')
            ;

            $browser
                ->click('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.error', 'The Name field is required.')
                ->click('a.flash-close')
            ;

            $browser
                ->type('Post[name]', 'Dusk Test')
                ->ajaxRequest('.form-buttons [data-request=onSave]')
                ->waitForTextIn('.oc-flash-message.success', 'Post Created')
                ->click('a.flash-close')
            ;

            $browser
                ->pause(300)
                ->script("$('.form-buttons [data-handler=onLoadDeleteReasonForm]').popup()")
            ;

            $browser
                ->waitForTextIn('.modal-title', 'Please give a reason')
                ->pause(300)
                ->press('Confirm delete')
                ->waitForTextIn('.modal-body > p', 'Do you really want to delete this post?')
                ->press('OK')
            ;

            $browser
                ->waitForLocation('/admin/october/test/posts')
                ->waitForTextIn('.oc-flash-message.success', 'Post Deleted')
                ->click('a.flash-close')
            ;
        });
    }
}
