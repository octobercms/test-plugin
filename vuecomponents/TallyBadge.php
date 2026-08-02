<?php namespace October\Test\VueComponents;

use System\Classes\VueComponentBase;

/**
 * TallyBadge displays a counter value, registered as a TallyCounter dependency.
 */
class TallyBadge extends VueComponentBase
{
    /**
     * @var string componentName is the Vue component tag name.
     */
    protected $componentName = 'october-test-tallybadge';
}
