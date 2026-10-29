<?php namespace October\Test\Tests;

use Flash;
use PluginTestCase;
use October\Test\Controllers\Pages;

/**
 * PagesControllerTest checks the AJAX handlers of the Pages controller.
 */
class PagesControllerTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testChangeHandlerFlashesMessage checks the recordfinder change handler in the people repeater sets an info flash message.
     */
    public function testChangeHandlerFlashesMessage()
    {
        (new Pages)->onTestChangeHandler();

        $this->assertEquals(['A person was picked in the People repeater.'], Flash::info());
    }
}
