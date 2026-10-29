<?php namespace October\Test\Models;

use October\Rain\Database\ExpandoModel;

/**
 * RepeaterItem stores relation repeater items in one table, where fields without a column are serialized into the value column.
 */
class RepeaterItem extends ExpandoModel
{
    use \October\Rain\Database\Traits\Sortable;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_repeater_items';

    /**
     * @var array expandoPassthru attributes that keep their own columns instead of being serialized
     */
    protected $expandoPassthru = ['parent_id', 'sort_order'];

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        'photos' => \System\Models\File::class,
    ];
}
