<?php namespace October\Test\Models;

use Model;

/**
 * PageBanner
 */
class PageBanner extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_page_banners';

    public $attachOne = [
        'image_desktop' => \System\Models\File::class
    ];
}
