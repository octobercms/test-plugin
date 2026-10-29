<?php namespace October\Test\Models;

use Model;

/**
 * Page tests the core translatable traits, nested forms, fields hidden by filterFields and the import and export models in models/page.
 */
class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Translatable;
    use \October\Rain\Database\Traits\TranslatableAttachments;

    /**
     * @var bool timestamps disabled, since the table has no timestamp columns
     */
    public $timestamps = false;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_pages';

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = [
        'people',
        'content',
        'mainimage'
    ];

    /**
     * @var array translatable attributes stored per locale, where secondimage and privateimage are attachments
     */
    public $translatable = [
        'title',
        'content',
        'mainimage',
        'image',
        'secondimage',
        'privateimage'
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'type' => 'required',
        'content.title' => 'required|min:3'
    ];

    /**
     * @var array belongsTo relations, where parent is a self reference
     */
    public $belongsTo = [
        'parent' => Page::class,
        'layout' => Layout::class,
        'pagebanner' => PageBanner::class,
    ];

    /**
     * @var array attachOne relations, where captionimage translates the file title and description
     */
    public $attachOne = [
        'secondimage' => \System\Models\File::class,
        'captionimage' => \System\Models\TranslatableFile::class,
        'privateimage' => [\System\Models\File::class, 'public' => false]
    ];

    /**
     * beforeValidate adds rules for the seeded third page, testing a rule on a related model's attribute.
     */
    public function beforeValidate()
    {
        if ($this->id === 3) {
            $this->rules += [
                'parent' => 'required',
                'parent.title' => 'size:10'
            ];
        }
    }

    /**
     * getParentScopeOptions returns the top level pages as options for the parent filter scope.
     */
    public function getParentScopeOptions()
    {
        return $this->whereNull('parent_id')->pluck('title', 'id')->all();
    }

    /**
     * getStatusOptions returns the page statuses for the status dropdown, list column and filter scope.
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
     * filterFields hides the layout and ghost fields, comments on the picked person in repeater items and fills the people repeater when the prepopulate switch is turned on.
     */
    public function filterFields($fields, $context = null)
    {
        if ($fields->layout) {
            $fields->layout->hidden(!$this->use_layout);
        }

        // Hide ghosted fields
        foreach ($fields as $field) {
            if (str_starts_with($field->fieldName, 'ghost_')) {
                $field->hidden();
            }
        }

        // Nested repeater item logic
        if ($context === 'update' && isset($fields->person)) {
            if ($fields->person->value) {
                $fields->description->comment = "Person ID: {$fields->person->value}";
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
