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
     * @var string table associated with the model
     */
    public $table = 'october_test_channels';

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = ['services'];

    /**
     * @var array belongsTo relations
     */
    public $belongsTo = [
        'user' => User::class
    ];

    /**
     * @var array belongsToMany relations, where related is a self referencing relation
     */
    public $belongsToMany = [
        'related' => [
            Channel::class,
            'table' => 'october_test_related_channels',
            'key' => 'related_id'
        ]
    ];

    /**
     * getCustomTitleAttribute returns the title with the record ID.
     */
    public function getCustomTitleAttribute()
    {
        return $this->title.' (#'.$this->id.')';
    }

    /**
     * getBasicFieldOptions returns plain options with a label only.
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
     * getSimpleFieldOptions returns options with a label and a comment.
     */
    public function getSimpleFieldOptions()
    {
        return [
            1 => ['Option 1', 'This is option one'],
            2 => ['Option 2', 'This is option two']
        ];
    }

    /**
     * getAdvancedFieldOptions returns options with icons, colors, child options and a disabled state.
     */
    public function getAdvancedFieldOptions()
    {
        return [
            100 => [
                'label' => 'Option 100',
                'comment' => 'This is option one (disabled)',
                'icon' => 'ph ph-gear-six',
                'disabled' => true,
            ],
            200 => [
                'label' => 'Option 200',
                'comment' => 'This is option two',
                'children' => $this->getSimpleFieldOptions(),
                'color' => '#ff0000',
            ]
        ];
    }

    /**
     * getBasicChildFieldOptions returns options inside an option group.
     */
    public function getBasicChildFieldOptions()
    {
        return [
            'Option Group' => [
                'optgroup' => true,
                'children' => [
                    1 => 'Option 1',
                    2 => 'Option 2',
                ]
            ],
        ];
    }
}
