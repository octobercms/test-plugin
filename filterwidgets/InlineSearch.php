<?php namespace October\Test\FilterWidgets;

use Backend\Classes\FilterWidgetBase;

class InlineSearch extends FilterWidgetBase
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->vars['scope'] = $this->filterScope;
        $this->vars['name'] = $this->getScopeName();
        $this->vars['value'] = $this->getLoadValue();

        return $this->makePartial('inlinesearch');
    }

    /**
     * renderForm for the filter
     */
    public function renderForm()
    {
    }

    /**
     * getActiveValue
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
     * applyScopeToQuery
     */
    public function applyScopeToQuery($query)
    {
        $searchValue = $this->filterScope->value;

        $query->where('username', 'LIKE', "%{$searchValue}%");
    }
}
