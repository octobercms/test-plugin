<?php namespace October\Test\Models;

use Model;

/**
 * Post Model
 */
class Post extends Model
{

    use \October\Rain\Database\Traits\Validation;

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name', 'content'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_posts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

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
        'comments' => ['October\Test\Models\Comment']
    ];

}