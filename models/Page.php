<?php namespace October\Test\Models;

use Model;

/**
 * Page
 */
class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * implement the TranslatableModel behavior softly
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var bool timestamps disabled by default
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_pages';

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [
        'people',
        'content',
        'mainimage'
    ];

    /**
     * @var array translatable
     */
    public $translatable = [
        'content',
        'mainimage',
        'image',
        'secondimage'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'type' => 'required',
        'content.title' => 'required|min:3'
    ];

    public $belongsTo = [
        'parent' => Page::class,
        'layout' => Layout::class,
    ];

    public $attachOne = [
        'secondimage' => \System\Models\File::class
    ];

    /**
     * getParentScopeOptions
     */
    public function getParentScopeOptions()
    {
        return $this->whereNull('parent_id')->pluck('title', 'id')->all();
    }

    /**
     * getStatusOptions
     */
    public function getStatusOptions()
    {
        return [
            0  => 'Not Validated',
            10 => 'Main Collection',
            11 => 'User Collection',
            12 => 'Skinfile Added',
            20 => 'Blacklisted',
            21 => 'Deleted',
        ];
    }

    /**
     * filterFields
     */
    public function filterFields($fields, $context = null)
    {
        if ($fields->layout) {
            $fields->layout->hidden(!$this->use_layout);
        }

        // Hide ghosted fields
        foreach ($fields as $field) {
            if (starts_with($field->fieldName, 'ghost_')) {
                $field->hidden();
            }
        }

        // Prepopulate people repeater
        if ($context === 'refresh' && $fields->_prepopulate_people !== null) {
            if ($fields->_prepopulate_people->value) {
                $fields->people->value = [
                    ['description' => 'First Person'],
                    ['description' => 'Second Person']
                ];
            }
            else {
                $fields->people->value = [];
            }
        }
    }
}
