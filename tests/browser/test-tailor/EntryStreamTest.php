<?php

/**
 * EntryStreamTest
 */
class EntryStreamTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;
    use \October\Test\Tests\Browser\Concerns\InteractsWithFaker;

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
     * testCreateEntries
     */
    public function testCreateEntries()
    {
        $this->browse(function($browser) {
            $browser
                ->visit('/admin/tailor/entries/test_blog')
                ->assertTitleContains('Manage Entries |')
            ;

            $browser
                ->click('#Toolbar-listToolbar .btn-primary')
                ->waitForLocation('/admin/tailor/entries/test_blog/create')
                ->waitForEvent('page:load', 'document')
                ->pause(300)
                ->type('EntryRecord[title]', $title = $this->generateRandomSentence(6))
                ->type('.fr-element.fr-view', $this->generateRandomSentence().PHP_EOL.$this->generateRandomSentence().PHP_EOL.$this->generateRandomSentence())
                ->press('Save and Close')
                ->waitForTextIn('.oc-flash-message.success', 'Entry Created')
                ->click('a.flash-close');
            ;

            $browser
                ->waitForTextIn('td.list-cell-name-title', $title)
            ;
        });
    }
}
