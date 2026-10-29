<?php namespace October\Test\Models;

use Model;

/**
 * CountryBrother is an item of the country brothers repeater stored as a related record, with its own photos and nested sisters.
 */
class CountryBrother extends Model
{
    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_country_brothers';

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        'photos' => \System\Models\File::class,
    ];

    /**
     * @var array hasMany relations, where sisters stores relation repeater items nested inside a brother
     */
    public $hasMany = [
        'sisters' => [
            RepeaterItem::class,
            'key' => 'parent_id',
            'delete' => true
        ],
    ];
}
