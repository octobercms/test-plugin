<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\Widgets\Lists;
use October\Test\Models\Role;
use October\Test\Models\User;
use October\Test\Controllers\Users;
use Backend\Models\User as BackendUser;

/**
 * UsersControllerTest checks the relation hooks of the Users controller.
 */
class UsersControllerTest extends PluginTestCase
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

        Role::create(['name' => 'test editor']);
        Role::create(['name' => 'publisher']);
    }

    /**
     * testRolesManageListOnlyOffersTestRoles checks linking roles to a user only lists roles with "test" in their name.
     */
    public function testRolesManageListOnlyOffersTestRoles()
    {
        $names = $this->makeManageListNames('roles');

        $this->assertContains('test editor', $names);
        $this->assertNotContains('publisher', $names);
    }

    /**
     * testOtherManageListsOfferEveryRole checks the roles filter is not applied to other relations.
     */
    public function testOtherManageListsOfferEveryRole()
    {
        $names = $this->makeManageListNames('roles_pivot');

        $this->assertContains('test editor', $names);
        $this->assertContains('publisher', $names);
    }

    /**
     * makeManageListNames builds a role list for the relation field, extends it with the controller and returns the listed names.
     */
    protected function makeManageListNames(string $field): array
    {
        $controller = new Users;

        $config = $controller->makeConfig('$/october/test/models/role/columns.yaml');
        $config->model = new Role;
        $config->alias = 'manageList';

        $widget = $controller->makeWidget(Lists::class, $config);
        $controller->relationExtendManageListWidget($widget, $field, new User);

        return $widget->prepareQuery()->pluck('name')->all();
    }
}
