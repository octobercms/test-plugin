<?php namespace October\Test\FilterWidgets;

use Backend\Classes\FilterWidgetBase;

/**
 * InlineBalloon is an inline filter widget that renders the scope options as a balloon selector in the filter bar, without a popover form.
 *
 * @link https://docs.octobercms.com/4.x/extend/lists/filter-widgets.html
 */
class InlineBalloon extends FilterWidgetBase
{
    /**
     * render the balloon selector inline with the filter
     */
    public function render()
    {
        $this->vars['scope'] = $this->filterScope;
        $this->vars['name'] = $this->getScopeName();
        $this->vars['value'] = $this->getLoadValue();

        return $this->makePartial('inlineballoon');
    }

    /**
     * getActiveValue returns null when the selected option is cleared, so the scope stops filtering.
     */
    public function getActiveValue()
    {
        if (post('clearScope')) {
            return null;
        }

        if (!$this->hasPostValue('value')) {
            return null;
        }

        return post($this->getScopeName());
    }

    /**
     * applyScopeToQuery finds the username that matches the selected option.
     */
    public function applyScopeToQuery($query)
    {
        $query->where('username', $this->filterScope->value);
    }
}
