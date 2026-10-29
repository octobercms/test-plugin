<?php namespace October\Test\Models;

use Model;
use October\Test\Classes\StatusEnum;

/**
 * Comment Model
 */
class Comment extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_comments';

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array casts attributes to native types, where status is a backed enum
     */
    protected $casts = [
        'status' => StatusEnum::class,
    ];

    /**
     * @var array fillable attributes that can be mass assigned
     */
    protected $fillable = ['name', 'content'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['breakdown', 'mood', 'quotes'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array belongsTo relations
     */
    public $belongsTo = [
        'user' => User::class,
        'post' => Post::class
    ];

    /**
     * @var array attachOne relations
     */
    public $attachOne = [
        'photo' => \System\Models\File::class
    ];

    /**
     * @var array hasMany relations, where child_comments includes soft deleted comments using the withTrashed scope
     */
    public $hasMany = [
        'child_comments' => [
            Comment::class,
            'key' => 'parent_comment_id',
            'scope' => 'withTrashed'
        ],
    ];

    /**
     * scopeIsVisible limits the query to visible comments, used as the scope of the Post comments relation.
     */
    public function scopeIsVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * getStatusOptions returns a label for each StatusEnum value, used by the status dropdown and column.
     */
    public function getStatusOptions()
    {
        return [
            StatusEnum::Draft->value => 'Draft',
            StatusEnum::Approved->value => 'Approved',
            StatusEnum::Rejected->value => 'Rejected',
            StatusEnum::Published->value => 'Published',
        ];
    }

    /**
     * getFeelingzOptions returns labels that lang/en.json translates, testing that option labels are translated.
     */
    public function getFeelingzOptions()
    {
        return [
            'sad' => 'Sad',
            'happy' => 'Happy',
            'trolling' => "Just trollin' y'all",
        ];
    }
}
