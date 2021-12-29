<?php namespace October\Test\Models;

use Model;
use October\Test\Models\Tag;

/**
 * Post Model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * implement the TranslatableModel behavior softly
     */
    // public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

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
     * @var array Jsonable fields
     */
    protected $jsonable = ['tags_array', 'tags_array_id'];

    /**
     * translatable
     */
    // public $translatable = ['content_html'];

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
        'comments' => [Comment::class, 'scope' => 'isVisible'],
        // @deprecated
        // 'comments_count' => ['October\Test\Models\Comment', 'scope' => 'isVisible', 'count' => true]
    ];

    public $belongsTo = [
        'status' => [
            Attribute::class,
            'conditions' => "type = 'general.status'"
        ],
        'user' => User::class,
    ];

    public $belongsToMany = [
        'tags' => [
            Tag::class,
            'table' => 'october_test_posts_tags',
            'key' => 'post_id',
            'otherKey' => 'tag_id'
        ]
    ];

    public $morphOne = [
        'review' => [Review::class, 'name' => 'product'],
    ];

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

    //
    // Options
    //

    public function getTagsArrayOptions($value, $formData)
    {
        return Tag::all()->lists('name');
    }

    public function getTagsStringOptions($value, $formData)
    {
        return $this->getTagsArrayOptions($value, $formData);
    }

    public function getTagsArrayIdOptions($value, $formData)
    {
        return Tag::all()->pluck('name', 'id')->toArray();
    }

    public function getTagsStringIdOptions($value, $formData)
    {
        return $this->getTagsArrayIdOptions($value, $formData);
    }
}
