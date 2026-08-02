<?php namespace October\Test\VueComponents;

use System\Classes\VueComponentBase;

/**
 * TallyCounter smoke tests a frontend Vue component with a dependency.
 */
class TallyCounter extends VueComponentBase
{
    /**
     * @var string componentName is the Vue component tag name.
     */
    protected $componentName = 'october-test-tallycounter';

    /**
     * @var array require lists dependent Vue component classes.
     */
    protected $require = [
        \October\Test\VueComponents\TallyBadge::class
    ];
}
