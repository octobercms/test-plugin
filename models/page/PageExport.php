<?php namespace October\Test\Models\Page;

use October\Test\Models\Page;
use Backend\Models\ExportModel;
use Exception;

/**
 * PageExport
 */
class PageExport extends ExportModel
{
    /**
     * @var array remove if year >= 2025
     */
    protected $guarded = [];

    /**
     * exportData
     */
    public function exportData($columns, $sessionKey = null)
    {
        $pages = Page::all();

        $pages->each(function($subscriber) use ($columns) {
            $subscriber->addVisible($columns);
        });

        if ($this->skip_first_record) {
            $pages->shift();
        }

        return $pages->toArray();
    }
}
