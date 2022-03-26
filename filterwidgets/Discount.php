<?php namespace October\Test\FilterWidgets;

use Backend\Classes\FilterWidgetBase;

class Discount extends FilterWidgetBase
{
    /**
     * @var bool allowSearch show the search input in the dropdown
     */
    public $allowSearch = false;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->fillFromConfig([
            'allowSearch',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->vars['allowSearch'] = $this->allowSearch;
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
        $hasDiscount = $this->filterScope->value;

        if ($hasDiscount) {
            $query->where('id', 1);
        }
        else {
            $query->where('id', 2);
        }
    }
}
