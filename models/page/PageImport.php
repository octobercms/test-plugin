<?php namespace October\Test\Models\Page;

use October\Test\Models\Page;
use Backend\Models\ImportModel;
use Exception;

/**
 * PageImport creates pages from the columns defined in models/page/columns_import.yaml.
 */
class PageImport extends ImportModel
{
    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * importData assigns each column explicitly, since the list includes a relation and a nested JSON key.
     */
    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
            try {
                $page = new Page;
                $page->title = $data['title'] ?? null;
                $page->type = $data['type'] ?? null;
                $page->status = $data['status'] ?? null;
                $page->content = ['title' => $data['content[title]'] ?? null];

                if ($parentTitle = $data['parent'] ?? null) {
                    $page->parent = Page::where('title', $parentTitle)->first();
                }

                $page->save();

                $this->logCreated();
            }
            catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }
}
