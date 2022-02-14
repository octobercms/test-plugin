<?php namespace October\Test\Models;

use Model;

/**
 * Phone Model
 */
class Phone extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_phones';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable fields
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
    public $belongsTo = [
        'person' => Person::class
    ];

    public $attachOne = [
        'picture' => \System\Models\File::class
    ];

    public function getBrandOptions()
    {
        return [
            'nokia'  => ['Nokia', '#666666'],
            'apple'  => ['Apple', '#ff9999'],
            'samsung' => ['Samsung', '#ff0000'],
        ];
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCustomSearch($query, $term)
    {
        $query->where('name', $term);
    }
}
