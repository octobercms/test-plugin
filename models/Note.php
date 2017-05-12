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
     * @var string The database connection used by the model.
     */
	public $connection = 'october_test';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Rules
     */
    public $rules = [
        'note' => 'required',
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'task' => ['October\Test\Models\Task']
    ];

}
