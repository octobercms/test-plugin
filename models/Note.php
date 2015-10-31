<?php namespace October\Test\Models;

use Model;

/**
 * Note Model
 */
class Note extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_notes';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'person' => ['October\Test\Models\Person']
    ];

}
