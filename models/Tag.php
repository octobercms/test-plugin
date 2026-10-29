<?php namespace October\Test\Models;

use Model;

/**
 * Tag Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_tags';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var bool timestamps disabled, since the table has no timestamp columns
     */
    public $timestamps = false;

    /**
     * @var array belongsToMany relations
     */
    public $belongsToMany = [
        'posts' => [
            Post::class,
            'table' => 'october_test_posts_tags',
            'key' => 'tag_id',
            'otherKey' => 'post_id'
        ]
    ];

    /**
     * getFullNameAttribute appends a fixed surname, testing an attribute accessor.
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' Grossbard';
    }
}
