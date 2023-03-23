<?php namespace October\Test\Models;

use October\Rain\Database\ExpandoModel;

/**
 * RepeaterItem
 */
class RepeaterItem extends ExpandoModel
{
    /**
     * @var string table used by the model.
     */
    public $table = 'october_test_repeater_items';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array expandoPassthru attributes that should not be serialized
     */
    protected $expandoPassthru = ['parent_id'];

    /**
     * @var array attachMany
     */
    public $attachMany = [
        'photos' => \System\Models\File::class,
    ];
}
