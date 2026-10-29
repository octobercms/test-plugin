<?php namespace October\Test\Models;

use Model;

/**
 * Post Model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_posts';

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name', 'content', 'content_html'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['tags_array', 'tags_array_id', 'tags_inline_options'];

    /**
     * @var array slugs generated from other attributes
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array hasMany relations, where comments only include visible comments using a scope
     */
    public $hasMany = [
        'comments' => [Comment::class, 'scope' => 'isVisible'],
    ];

    /**
     * @var array belongsTo relations, where status shares the attributes table with other types using conditions
     */
    public $belongsTo = [
        'status' => [
            Attribute::class,
            'conditions' => "type = 'general.status'"
        ],
        'user' => User::class,
    ];

    /**
     * @var array belongsToMany relations
     */
    public $belongsToMany = [
        'tags' => [
            Tag::class,
            'table' => 'october_test_posts_tags',
            'key' => 'post_id',
            'otherKey' => 'tag_id'
        ]
    ];

    /**
     * @var array morphOne relations, where the review morph is named "product" for every model that can be reviewed
     */
    public $morphOne = [
        'review' => [Review::class, 'name' => 'product'],
    ];

    /**
     * @var array morphToMany relations, where galleries_pivot adds a pivot column to the same table
     */
    public $morphToMany = [
        'galleries' => [
            Gallery::class,
            'name' => 'entity',
            'table' => 'october_test_gallery_entity'
        ],
        'galleries_pivot' => [
            Gallery::class,
            'name' => 'entity',
            'table' => 'october_test_gallery_entity',
            'pivot' => ['commission_amount']
        ],
    ];

    /**
     * getTagsArrayOptions returns the tag names for the taglist that stores an array.
     */
    public function getTagsArrayOptions($value, $formData)
    {
        return Tag::all()->pluck('name')->all();
    }

    /**
     * getTagsStringOptions returns the tag names for the taglist that stores a separated string.
     */
    public function getTagsStringOptions($value, $formData)
    {
        return $this->getTagsArrayOptions($value, $formData);
    }

    /**
     * getTagsArrayIdOptions returns the tag names keyed by ID for the taglist that stores an array of keys.
     */
    public function getTagsArrayIdOptions($value, $formData)
    {
        return Tag::all()->pluck('name', 'id')->toArray();
    }

    /**
     * getTagsStringIdOptions returns the tag names keyed by ID for the taglist that stores a separated string of keys.
     */
    public function getTagsStringIdOptions($value, $formData)
    {
        return $this->getTagsArrayIdOptions($value, $formData);
    }
}
