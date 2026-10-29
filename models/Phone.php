<?php namespace October\Test\Models;

use Model;

/**
 * Phone Model
 */
class Phone extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_phones';

    /**
     * @var array guarded keeps Phone totally guarded to test nested relation fields saving without mass assignment
     */
    protected $guarded = ['*'];

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
        'person' => Person::class
    ];

    /**
     * @var array attachOne relations
     */
    public $attachOne = [
        'picture' => \System\Models\File::class
    ];

    /**
     * getBrandOptions returns a label and a color for each brand, testing colored dropdown options and list columns.
     */
    public function getBrandOptions()
    {
        return [
            'nokia'  => ['Nokia', '#666666'],
            'apple'  => ['Apple', '#ff9999'],
            'samsung' => ['Samsung', '#ff0000'],
        ];
    }

    /**
     * scopeIsActive limits the query to active phones, used as the scope of the Person phone relation.
     */
    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * scopeCustomSearch matches the exact phone name, used as a custom search scope by the phone record finder and list.
     */
    public function scopeCustomSearch($query, $term)
    {
        $query->where('name', $term);
    }
}
