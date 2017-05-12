<?php namespace October\Test\Models;

use Model;

/**
 * Task Model
 */
class Task extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_tasks';

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
        'name' => 'required',
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'notes' => ['October\Test\Models\Note', 'key' => 'task_id']
    ];

}
