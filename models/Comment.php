<?php namespace October\Test\Models;

use Model;

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
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
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

    public function scopeIsVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function getFeelingOptions()
    {
        return [
            'sad'      => 'Sad',
            'happy'    => 'Happy',
            'trolling' => "Just trollin' y'all",
        ];
    }
}
