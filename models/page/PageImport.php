<?php namespace October\Test\Models\Page;

use October\Test\Models\Page;
use Backend\Models\ImportModel;
use Exception;

/**
 * PageImport
 */
class PageImport extends ImportModel
{
    /**
     * @var array rules to be applied to the data.
     */
    public $rules = [];

    /**
     * importData
     */
    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
            try {
                $page = new Page;
                $page->fill($data);
                $page->save();

                $this->logCreated();
            }
            catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }
}
