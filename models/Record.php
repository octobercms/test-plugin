<?php namespace October\Test\Models;

use Model;

/**
 * Model
 */
class Record extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_records';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['title', 'fields_in_json[test1]', 'fields_in_json[test2]'];

    protected $casts = [
        'fields_in_json' => 'array'
    ];
}