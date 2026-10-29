<?php namespace October\Test\FilterWidgets;

use Backend\Classes\FilterWidgetBase;

/**
 * InlineSearch is an inline filter widget that renders a search input and button in the filter bar, without a popover form.
 *
 * @link https://docs.octobercms.com/4.x/extend/lists/filter-widgets.html
 */
class InlineSearch extends FilterWidgetBase
{
    /**
     * render the search input inline with the filter
     */
    public function render()
    {
        $this->vars['scope'] = $this->filterScope;
        $this->vars['name'] = $this->getScopeName();
        $this->vars['value'] = $this->getLoadValue();

        return $this->makePartial('inlinesearch');
    }

    /**
     * applyScopeToQuery finds usernames that contain the search value.
     */
    public function applyScopeToQuery($query)
    {
        $searchValue = $this->filterScope->value;

        $query->where('username', 'LIKE', "%{$searchValue}%");
    }
}
