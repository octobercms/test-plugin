<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Page;
use October\Test\Models\Page\PageImport;

/**
 * PageImportTest checks the page import model against the columns in models/page/columns_import.yaml, which controllers/pages/config_import_export.yaml uses for the import.
 */
class PageImportTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testImportCreatesPageWithParentAndContent checks a valid row creates a page linked to its parent.
     */
    public function testImportCreatesPageWithParentAndContent()
    {
        $parent = new Page;
        $parent->title = 'Import Parent';
        $parent->type = 1;
        $parent->content = ['title' => 'Parent content'];
        $parent->save();

        $importer = new PageImport;
        $importer->importData([
            ['title' => 'Imported Page', 'type' => 1, 'status' => 'draft', 'content[title]' => 'Imported content', 'parent' => 'Import Parent'],
        ]);

        $stats = $importer->getResultStats();
        $this->assertEquals(1, $stats->created);
        $this->assertEquals(0, $stats->errorCount);

        $page = Page::where('title', 'Imported Page')->first();
        $this->assertNotNull($page);
        $this->assertEquals('Imported content', $page->content['title']);
        $this->assertEquals($parent->id, $page->parent_id);
    }

    /**
     * testImportLogsInvalidRows checks a row that fails validation is logged and not created.
     */
    public function testImportLogsInvalidRows()
    {
        $importer = new PageImport;
        $importer->importData([
            ['title' => 'Missing Type', 'content[title]' => 'Some content'],
        ]);

        $stats = $importer->getResultStats();
        $this->assertEquals(0, $stats->created);
        $this->assertEquals(1, $stats->errorCount);
        $this->assertNull(Page::where('title', 'Missing Type')->first());
    }
}
