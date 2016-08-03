<?php namespace October\Test\Models;

use Model;

/**
 * Post Model
 */
class Post extends Model
{

    use \October\Rain\Database\Traits\Validation;

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
        'comments' => ['October\Test\Models\Comment', 'scope' => 'isVisible'],
        'comments_count' => ['October\Test\Models\Comment', 'scope' => 'isVisible', 'count' => true]
    ];

    public $belongsTo = [
        'status' => ['October\Test\Models\Attribute', 'conditions' => "type = 'general.status'"],
    ];

    // Demonstrates inability to disable a relationController through filterFields
    public function filterFields($fields, $context = null) {
        // If the post is 'active', then apply rules
        if ($context = 'update' && $this->status && $this->status->code === 'active') {
            // Disable the name field from being modified as the post is active
            $fields->name->disabled = true;
            
            // Attempt to disable the comments 'field' as the post is active
            // NOTE: This does not work as the 'field' is a partial calling `$this->relationRender();`
            //       so disabling it doesn't actually change the readOnly property of the relationController
            $fields->comments->disabled = true;
        }
    }
}
