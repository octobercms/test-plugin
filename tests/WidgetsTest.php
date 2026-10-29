<?php namespace October\Test\Tests;

use Flash;
use Artisan;
use PluginTestCase;
use ForbiddenException;
use Backend\Widgets\Form;
use Backend\Widgets\Filter;
use Backend\Classes\Controller;
use Backend\Classes\AuthManager;
use October\Test\Models\User;
use October\Test\Models\Review;
use October\Test\Controllers\Users;
use October\Test\Controllers\Reviews;
use October\Test\FormWidgets\TimeChecker;
use October\Test\ReportWidgets\ClearCache;
use Backend\Models\User as BackendUser;

/**
 * WidgetsTest checks the report, form and filter widgets provided by the plugin.
 */
class WidgetsTest extends PluginTestCase
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
     * testClearCacheRequiresManageSettings checks onClearCache throws ForbiddenException for a user without the manage_settings permission.
     */
    public function testClearCacheRequiresManageSettings()
    {
        $this->actingAs($this->makeBackendUser(['october.test.access_plugin' => 1]));

        $this->expectException(ForbiddenException::class);

        $this->makeClearCacheWidget()->onClearCache();
    }

    /**
     * testClearCacheRunsForManageSettings checks onClearCache calls cache:clear for a user with the manage_settings permission, through a stand-in so nothing is cleared.
     */
    public function testClearCacheRunsForManageSettings()
    {
        $this->actingAs($this->makeBackendUser(['october.test.manage_settings' => 1]));

        $artisan = new class {
            /**
             * @var array commands that were called
             */
            public array $commands = [];

            /**
             * call records the command instead of running it.
             */
            public function call(string $command): int
            {
                $this->commands[] = $command;

                return 0;
            }
        };

        Artisan::swap($artisan);

        $this->makeClearCacheWidget()->onClearCache();

        $this->assertEquals(['cache:clear'], $artisan->commands);
        $this->assertEquals(['Cache cleared.'], Flash::success());
    }

    /**
     * testTimeCheckerOnlyAcceptsAllowedSizes checks a posted size from the allowlist sets the image URL and any other size falls back to 50x50.
     */
    public function testTimeCheckerOnlyAcceptsAllowedSizes()
    {
        $widget = $this->makeTimeCheckerWidget();

        $this->postData(['size' => '300x300']);
        $widget->onPullImage();
        $this->assertStringContainsString('src="https://picsum.photos/300/300"', $widget->makePartial('big_image'));

        $this->postData(['size' => '300x300" onerror="alert(1)']);
        $widget->onPullImage();
        $html = $widget->makePartial('big_image');

        $this->assertStringContainsString('src="https://picsum.photos/50/50"', $html);
        $this->assertStringNotContainsString('onerror', $html);
    }

    /**
     * testInlineBalloonEmptySelectionHasNoValue checks an empty balloon selection gives a null active value, so the scope stops filtering.
     */
    public function testInlineBalloonEmptySelectionHasNoValue()
    {
        $balloon = $this->makeUserFilter()->getFilterWidget('testtoggle');

        $this->postData(['CustomFilter' => ['testtoggle' => ['value' => 'Neo']]]);
        $this->assertEquals(['value' => 'Neo'], $balloon->getActiveValue());

        $this->postData(['CustomFilter' => ['testtoggle' => ['value' => '']]]);
        $this->assertNull($balloon->getActiveValue());
    }

    /**
     * testInlineBalloonMatchesUsernameExactly checks the selected option filters users by an equality match on username.
     */
    public function testInlineBalloonMatchesUsernameExactly()
    {
        $this->makeUser('Neo');
        $this->makeUser('Neon');

        $filter = $this->makeUserFilter();
        $filter->putScopeValue('testtoggle', ['value' => 'Neo']);

        $usernames = $filter->applyScopeToQuery('testtoggle', User::query())->pluck('username')->all();

        $this->assertContains('Neo', $usernames);
        $this->assertNotContains('Neon', $usernames);
    }

    /**
     * makeClearCacheWidget creates the report widget with its default properties.
     */
    protected function makeClearCacheWidget(): ClearCache
    {
        return new ClearCache(new Controller, null);
    }

    /**
     * makeTimeCheckerWidget builds a review form with the widget's registered field type and returns the widget.
     */
    protected function makeTimeCheckerWidget(): TimeChecker
    {
        $form = new Form(new Reviews, [
            'model' => new Review,
            'fields' => [
                '_check_time' => ['type' => 'timecheckertest'],
            ],
        ]);

        $form->bindToController();

        return $form->getFormWidget('_check_time');
    }

    /**
     * makeUserFilter builds the user list filter from its scopes file, the way ListController does.
     */
    protected function makeUserFilter(): Filter
    {
        $controller = new Users;

        $config = $controller->makeConfig('$/october/test/models/user/scopes.yaml');
        $config->model = new User;
        $config->alias = 'listFilter';

        $filter = $controller->makeWidget(Filter::class, $config);
        $filter->bindToController();

        return $filter;
    }

    /**
     * makeUser creates a user record, skipping validation since users require uploads and roles.
     */
    protected function makeUser(string $username): User
    {
        $user = new User;
        $user->username = $username;
        $user->forceSave();

        return $user;
    }

    /**
     * makeBackendUser returns an unsaved backend user with the given permissions and no superuser access.
     */
    protected function makeBackendUser(array $permissions): BackendUser
    {
        $user = new BackendUser;
        $user->login = 'restricted';
        $user->is_superuser = false;
        $user->permissions = $permissions;

        return $user;
    }

    /**
     * postData replaces the request with a POST request carrying the data, since post() ignores other methods.
     */
    protected function postData(array $data): void
    {
        request()->setMethod('POST');
        request()->request->replace($data);
    }
}
