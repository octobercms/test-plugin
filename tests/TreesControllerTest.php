<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Channel;
use October\Test\Controllers\Trees;
use Backend\Models\User as BackendUser;

/**
 * TreesControllerTest checks the channel lists on the Trees page split active and trashed channels.
 */
class TreesControllerTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * setUp signs in a backend user, since Lists loads column preferences for the current user.
     */
    public function setUp(): void
    {
        parent::setUp();

        $superUser = new BackendUser;
        $superUser->login = 'tester';
        $superUser->is_superuser = true;

        $this->actingAs($superUser);
    }

    /**
     * testTrashedChannelsListOnlyShowsTrashedChannels checks listExtendQuery limits the trashed_channels list to soft deleted channels.
     */
    public function testTrashedChannelsListOnlyShowsTrashedChannels()
    {
        $this->makeChannel('Active channel');
        $this->makeChannel('Trashed channel')->delete();

        $records = (new Trees)->makeList('trashed_channels')->prepareQuery()->get();

        $this->assertContains('Trashed channel', $records->pluck('title')->all());
        $this->assertNotContains('Active channel', $records->pluck('title')->all());
        $this->assertTrue($records->every(fn($channel) => $channel->trashed()));
    }

    /**
     * testChannelsListExcludesTrashedChannels checks the channels list shows active channels and leaves out soft deleted ones.
     */
    public function testChannelsListExcludesTrashedChannels()
    {
        $this->makeChannel('Active channel');
        $this->makeChannel('Trashed channel')->delete();

        $titles = (new Trees)->makeList('channels')->prepareQuery()->pluck('title')->all();

        $this->assertContains('Active channel', $titles);
        $this->assertNotContains('Trashed channel', $titles);
    }

    /**
     * makeChannel creates a root channel with a title.
     */
    protected function makeChannel(string $title): Channel
    {
        $channel = new Channel;
        $channel->title = $title;
        $channel->save();

        return $channel;
    }
}
