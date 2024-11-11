<?php namespace October\Test\Models;

use Model;

/**
 * Channel Model
 */
class Channel extends Model
{
    use \October\Rain\Database\Traits\NestedTree;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'october_test_channels';

    /**
     * @var array fillable fields
     */
    protected $fillable = [];

    /**
     * @var array jsonable fields
     */
    protected $jsonable = ['services'];

    /**
     * @var array belongsTo
     */
    public $belongsTo = [
        'user' => User::class
    ];

    /**
     * @var array belongsToMany
     */
    public $belongsToMany = [
        'related' => [
            Channel::class,
            'table' => 'october_test_related_channels',
            'key' => 'related_id'
        ]
    ];

    /**
     * getCustomTitleAttribute
     */
    public function getCustomTitleAttribute()
    {
        return $this->title.' (#'.$this->id.')';
    }

    /**
     * getBasicFieldOptions
     */
    public function getBasicFieldOptions()
    {
        return [
            1 => 'Calibration',
            2 => 'Commerce',
            3 => 'Service'
        ];
    }

    /**
     * getSimpleRadioOptions
     */
    public function getSimpleFieldOptions()
    {
        return [
            1 => ['Option 1', 'This is option one'],
            2 => ['Option 2', 'This is option two']
        ];
    }

    /**
     * getAdvancedRadioOptions
     */
    public function getAdvancedFieldOptions()
    {
        return [
            100 => [
                'label' => 'Option 100',
                'comment' => 'This is option one',
                'icon' => 'icon-cogs',
                'disabled' => true,
            ],
            200 => [
                'label' => 'Option 200',
                'comment' => 'This is option two (disabled)',
                'children' => $this->getSimpleFieldOptions(),
                'color' => '#ff0000',
                // 'readOnly' => true,
            ]
        ];
    }

    /**
     * getBasicChildFieldOptions
     */
    public function getBasicChildFieldOptions()
    {
        return [
            'Option Group' => [
                'optgroup' => true,
                'children' => [
                    1 => 'Option 1',
                    2 => 'Option 2',
                    // ...
                ]
            ],
        ];

        $categories = [
            'Option Group' => [
                'optgroup' => true,
                'children' => [
                    1 => 'Option 1',
                    2 => 'Option 2',
                ]
            ],
        ];

        $arAdditionFields = [
            'bling_category_id'     => [
                'tab'      => 'Bling ERP',
                'label'    => 'Categoria relacionada',
                'type'     => 'dropdown',
                'span'     => 'storm',
                'cssClass' => 'col-md-6',
                'options'  => $categories
            ],
        ];
    }
}
