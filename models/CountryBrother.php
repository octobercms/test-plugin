<?php namespace October\Test\Models;

use Model;

/**
 * CountryBrother
 */
class CountryBrother extends Model
{
    /**
     * @var string table used by the model.
     */
    public $table = 'october_test_country_brothers';

    /**
     * @var array attachMany
     */
    public $attachMany = [
        'photos' => \System\Models\File::class,
    ];

    /**
     * @var array hasMany
     */
    public $hasMany = [
        'sisters' => [
            RepeaterItem::class,
            'key' => 'parent_id',
            'delete' => true
        ],
    ];
}
