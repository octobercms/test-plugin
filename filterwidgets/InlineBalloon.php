<?php namespace October\Test\FilterWidgets;

use Backend\Classes\FilterWidgetBase;

class InlineBalloon extends FilterWidgetBase
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

        return $this->makePartial('inlineballoon');
    }

    /**
     * renderForm for the filter
     */
    public function renderForm()
    {
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
