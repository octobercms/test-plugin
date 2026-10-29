<?php namespace October\Test\Models\Page;

use October\Test\Models\Page;
use Backend\Models\ExportModel;

/**
 * PageExport exports pages with a custom skip_first_record option from the export form.
 */
class PageExport extends ExportModel
{
    /**
     * exportData returns every page with the chosen columns visible, leaving out the first page when skip_first_record is checked.
     */
    public function exportData($columns, $sessionKey = null)
    {
        $pages = Page::all();

        $pages->each(function($page) use ($columns) {
            $page->addVisible($columns);
        });

        if ($this->skip_first_record) {
            $pages->shift();
        }

        return $pages->toArray();
    }
}
