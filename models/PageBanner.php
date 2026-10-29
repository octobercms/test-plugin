<?php namespace October\Test\Models;

use Model;

/**
 * PageBanner is the banner picked on the page form, testing translatable file captions inside a relation popup.
 */
class PageBanner extends Model
{
    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_page_banners';

    /**
     * @var array attachOne relations, where caption_image translates the file title and description
     */
    public $attachOne = [
        'image_desktop' => \System\Models\File::class,
        'caption_image' => \System\Models\TranslatableFile::class
    ];
}
