<?php namespace October\Test\Models;

use Model;

/**
 * Content Model
 */
class Content extends Model
{
    public $table = 'october_test_contents';
    protected $fillable = ['title', 'body'];
    protected $touches = ['page'];

    public $belongsTo = [
        'page' => Page::class,
    ];
}
