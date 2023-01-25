<?php

/**
 * EntryStreamTest
 */
class EntryStreamTest extends BrowserTestCase
{
    use \October\Test\Tests\Browser\Concerns\InteractsWithAuth;
    use \October\Test\Tests\Browser\Concerns\InteractsWithFaker;

    /**
     * testCreateEntries
     */
    public function testCreateEntries()
    {
        $this->browse(function($browser) {
            $this->loginToBrowser($browser);

            $browser
                ->visit('/admin/tailor/entries/test_blog')
                ->assertTitleContains('Manage Entries |')
            ;

            $browser
                ->click('#Toolbar-listToolbar .btn-primary')
                ->waitForLocation('/admin/tailor/entries/test_blog/create')
                ->waitForEvent('page:load', 'document')
                ->pause(300)
                ->type('EntryRecord[title]', $title = $this->generateRandomSentence())
                ->type('.fr-element.fr-view', $this->generateRandomSentence(50).PHP_EOL.$this->generateRandomSentence(75).PHP_EOL.$this->generateRandomSentence(25))
                ->press('Save and Close')
                ->waitForTextIn('.oc-flash-message', 'Entry Created')
                ->click('a.flash-close');
            ;

            $browser
                ->waitForTextIn('td.list-cell-name-title', $title)
            ;
        });
    }
}
