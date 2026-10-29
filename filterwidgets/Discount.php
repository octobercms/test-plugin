<?php namespace October\Test\FilterWidgets;

use Backend\Classes\FilterWidgetBase;

/**
 * Discount is a filter widget that captures a value with a popover form, matching the filter widgets docs example.
 *
 * @link https://docs.octobercms.com/4.x/extend/lists/filter-widgets.html
 */
class Discount extends FilterWidgetBase
{
    /**
     * @var bool allowSearch show the search input in the dropdown
     */
    public $allowSearch = false;

    /**
     * init the widget
     */
    public function init()
    {
        $this->fillFromConfig([
            'allowSearch',
        ]);
    }

    /**
     * render the filter label and its current state
     */
    public function render()
    {
        $this->vars['scope'] = $this->filterScope;
        $this->vars['name'] = $this->getScopeName();
        $this->vars['value'] = $this->getLoadValue();

        return $this->makePartial('discount');
    }

    /**
     * renderForm for the filter
     */
    public function renderForm()
    {
        $this->vars['allowSearch'] = $this->allowSearch;
        $this->vars['scope'] = $this->filterScope;
        $this->vars['name'] = $this->getScopeName();
        $this->vars['value'] = $this->getLoadValue();

        return $this->makePartial('discount_form');
    }

    /**
     * getActiveValue captures the filter form values, or returns null to clear the scope.
     */
    public function getActiveValue()
    {
        if (post('clearScope')) {
            return null;
        }

        if (!$this->hasPostValue('value')) {
            return null;
        }

        return post('Filter');
    }

    /**
     * applyScopeToQuery applies the captured value to the list query.
     */
    public function applyScopeToQuery($query)
    {
        $hasDiscount = $this->filterScope->value;

        // Testing a placeholder condition, since the users table has no discount column like the docs example
        if ($hasDiscount) {
            $query->where('id', 1);
        }
        else {
            $query->where('id', 2);
        }
    }
}
