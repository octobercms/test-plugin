<?php namespace October\Test\VueComponents;

use System\Classes\VueComponentBase;

/**
 * LazyPanel smoke tests a Vue component registered during an AJAX request.
 */
class LazyPanel extends VueComponentBase
{
    /**
     * @var string componentName is the Vue component tag name.
     */
    protected $componentName = 'october-test-lazypanel';
}
