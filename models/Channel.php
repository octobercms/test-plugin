<?php namespace October\Test\Models;

use Model;

/**
 * Channel Model
 */
class Channel extends Model
{
    use \October\Rain\Database\Traits\NestedTree;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_channels';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'user' => User::class
    ];

    public $belongsToMany = [
        'related' => [
            Channel::class,
            'table' => 'october_test_related_channels',
            'key' => 'related_id'
        ]
    ];

    public function getCustomTitleAttribute()
    {
        return $this->title.' (#'.$this->id.')';
    }
}
