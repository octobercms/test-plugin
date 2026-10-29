<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Controllers\Orders;
use Backend\Models\User as BackendUser;

/**
 * OrdersControllerTest checks the data table popup handler of the Orders controller.
 */
class OrdersControllerTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * setUp signs in a backend user, since the data table widget loads preferences for the current user.
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
     * testDataTablePopupOnlyHasDismissButtons checks the popup renders the data table with buttons that close it and no submit button.
     */
    public function testDataTablePopupOnlyHasDismissButtons()
    {
        $html = (new Orders)->onLoadDataTablePopup();
        preg_match_all('/<button\b[^>]*>/', $html, $buttons);

        $this->assertStringContainsString('data-alias="add_database_columns_datatable"', $html);
        $this->assertStringNotContainsString('type="submit"', $html);
        $this->assertCount(3, $buttons[0]);

        foreach ($buttons[0] as $button) {
            $this->assertStringContainsString('type="button"', $button);
            $this->assertStringContainsString('data-dismiss="popup"', $button);
        }
    }
}
