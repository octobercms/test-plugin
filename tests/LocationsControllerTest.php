<?php namespace October\Test\Tests;

use Db;
use PluginTestCase;
use System\Models\File;
use October\Test\Models\Location;
use October\Test\Controllers\Locations;

/**
 * LocationsControllerTest checks the Locations controller loads the form model efficiently.
 */
class LocationsControllerTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testFormModelLoadsAttachmentsInOneQuery checks every attachment relation loads with a single combined query.
     */
    public function testFormModelLoadsAttachmentsInOneQuery()
    {
        $location = new Location;
        $location->name = 'Attachment test';
        $location->save();

        $this->makeAttachment($location, 'file01');
        $this->makeAttachment($location, 'file13');

        $location = Location::find($location->id);
        $controller = new Locations;

        Db::flushQueryLog();
        Db::enableQueryLog();
        $controller->formExtendModel($location);
        $queries = Db::getQueryLog();
        Db::disableQueryLog();

        $this->assertCount(1, $queries);
        $this->assertEquals('file01.txt', $location->file01->file_name);
        $this->assertEquals('file13.txt', $location->file13->file_name);
        $this->assertTrue($location->relationLoaded('file02'));
        $this->assertNull($location->file02);
    }

    /**
     * makeAttachment stores a file record for the attachment relation without writing a file to disk.
     */
    protected function makeAttachment(Location $location, string $field): void
    {
        $file = new File;
        $file->disk_name = $field . '.txt';
        $file->file_name = $field . '.txt';
        $file->file_size = 1;
        $file->content_type = 'text/plain';
        $file->field = $field;
        $file->attachment_id = $location->id;
        $file->attachment_type = $location->getMorphClass();
        $file->is_public = true;
        $file->save();
    }
}
