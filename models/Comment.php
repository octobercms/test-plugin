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
     * @var string The database table used by the model.
     */
    public $table = 'october_test_comments';

    /**
     * @var array dates
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array casts
     */
    protected $casts = [
        // PHP 8.1
        // 'status' => StatusEnum::class,
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable fields
     */
    protected $fillable = ['name', 'content'];

    /**
     * @var array Jsonable fields
     */
    protected $jsonable = ['breakdown', 'mood', 'quotes'];

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'user' => User::class,
        'post' => Post::class
    ];

    public $attachOne = [
        'photo' => \System\Models\File::class
    ];

    /**
     * scopeIsVisibleWithTrashed
     */
    public function scopeIsVisibleWithTrashed($query)
    {
        return $query->withTrashed()->isVisible();
    }

    /**
     * scopeIsVisible
     */
    public function scopeIsVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * getStatusOptions
     */
    public function getStatusOptions()
    {
        return [
            StatusEnum::DRAFT->value => 'Draft',
            StatusEnum::APPROVED->value => 'Approved',
            StatusEnum::REJECTED->value => 'Rejected',
            StatusEnum::PUBLISHED->value => 'Published',
        ];
    }

    /**
     * getFeelingzOptions
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
