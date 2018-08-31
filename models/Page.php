<?php namespace October\Test\Models;

use Model;

/**
 * Page Model
 */
class Page extends Model
{
    use \October\Rain\Database\Traits\NestedTree;

    public $table = 'october_test_pages';

    public $hasOne = [
        'content' => Content::class,
    ];
}
