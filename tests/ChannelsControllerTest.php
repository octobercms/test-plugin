<?php namespace October\Test\Tests;

use Flash;
use PluginTestCase;
use ForbiddenException;
use October\Test\Models\Channel;
use October\Test\Controllers\Channels;
use Backend\Classes\AuthManager;
use Backend\Models\User as BackendUser;
use Illuminate\Http\RedirectResponse;

/**
 * ChannelsControllerTest checks the restore handler on the channel update page.
 */
class ChannelsControllerTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * tearDown signs out by forgetting the backend auth manager, which outlives the test application.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        AuthManager::forgetInstance();
    }

    /**
     * testRestoreUntrashesChannel checks the restore handler restores a soft deleted channel and flashes a message.
     */
    public function testRestoreUntrashesChannel()
    {
        $channel = $this->makeTrashedChannel('Restored channel');

        $response = (new Channels)->update_onRestore($channel->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertFalse(Channel::find($channel->id)->trashed());
        $this->assertEquals(['Channel Restored'], Flash::success());
    }

    /**
     * testRestoreRequiresModelDeletePermission checks the restore handler throws ForbiddenException when the form config guards modelDelete with a permission the user lacks.
     */
    public function testRestoreRequiresModelDeletePermission()
    {
        $channel = $this->makeTrashedChannel('Guarded channel');
        $this->actingAs($this->makeUser(['october.test.access_plugin' => 1]));

        $controller = $this->makeGuardedController();

        $this->expectException(ForbiddenException::class);

        $controller->update_onRestore($channel->id);
    }

    /**
     * testRestoreAllowsModelDeletePermission checks a user with the configured modelDelete permission can restore a channel.
     */
    public function testRestoreAllowsModelDeletePermission()
    {
        $channel = $this->makeTrashedChannel('Permitted channel');
        $this->actingAs($this->makeUser(['october.test.access_plugin' => 1, 'october.test.reorder_trees' => 1]));

        $this->makeGuardedController()->update_onRestore($channel->id);

        $this->assertFalse(Channel::find($channel->id)->trashed());
    }

    /**
     * makeGuardedController returns the controller with modelDelete guarded by a permission, as `permissions: modelDelete:` in config_form.yaml would.
     */
    protected function makeGuardedController(): Channels
    {
        $controller = new Channels;
        $controller->formGetConfig()->permissions = ['modelDelete' => 'october.test.reorder_trees'];

        return $controller;
    }

    /**
     * makeTrashedChannel creates a channel and soft deletes it.
     */
    protected function makeTrashedChannel(string $title): Channel
    {
        $channel = new Channel;
        $channel->title = $title;
        $channel->save();
        $channel->delete();

        return $channel;
    }

    /**
     * makeUser returns an unsaved backend user with the given permissions and no superuser access.
     */
    protected function makeUser(array $permissions): BackendUser
    {
        $user = new BackendUser;
        $user->login = 'restricted';
        $user->is_superuser = false;
        $user->permissions = $permissions;

        return $user;
    }
}
