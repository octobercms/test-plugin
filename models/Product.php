<?php namespace October\Test\Models;

use Model;

/**
 * Product Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \Tailor\Traits\BlueprintRelationModel;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_products';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'title' => 'required|unique_site',
        // Testing a rule on a relation, which validates the number of related records
        'location_sold' => 'between:0,2'
    ];

    /**
     * @var array propagatable attributes to copy to other sites
     */
    protected $propagatable = [
        'title',
        'price',
        'slug',
        'company',
    ];

    /**
     * @var bool propagatableSync keeps the record structure the same across all sites
     */
    protected $propagatableSync = true;

    /**
     * @var array slugs generated from other attributes
     */
    protected $slugs = ['slug' => 'title'];

    /**
     * @var array jsonable attributes stored as JSON
     */
    protected $jsonable = [
        'prices'
    ];

    /**
     * @var array belongsTo relations, where author is a Tailor entry and company includes soft deleted companies
     */
    public $belongsTo = [
        'location_built' => [
            Location::class,
            'key' => 'location_id'
        ],
        // Testing belongsTo a Tailor entry, see blueprints/blog/authors.yaml
        'author' => [
            \Tailor\Models\EntryRecord::class,
            'blueprint' => 'e183d98c-e7ef-4142-a5d4-f56b596a9fa3'
        ],
        'company' => [
            Company::class,
            'scope' => 'withTrashed'
        ]
    ];

    /**
     * @var array belongsToMany relations, where categories link by site_root_id so every site copy of a category shares its links
     */
    public $belongsToMany = [
        'location_sold' => [
            Location::class,
            'table' => 'october_test_products_locations',
            'key' => 'product_id',
            'otherKey' => 'location_id',
        ],
        'categories' => [
            ProductCategory::class,
            'table' => 'october_test_products_categories',
            'key' => 'product_id',
            'otherKey' => 'category_id',
            'relatedKey' => 'site_root_id'
        ],
        'members' => [
            Member::class,
            'table' => 'october_test_products_members',
            'key' => 'product_id',
            'otherKey' => 'member_id',
        ],
        'related_products' => [
            Product::class,
            'table' => 'october_test_products_related_products',
            'key' => 'product_id',
            'otherKey' => 'related_product_id',
            'pivot' => ['group_name']
        ],
        // Testing belongsToMany Tailor stream records, see blueprints/stream/stream.yaml
        'stream_records' => [
            \Tailor\Models\StreamRecord::class,
            'table' => 'october_test_products_stream_records',
            'key' => 'product_id',
            'otherKey' => 'stream_record_id',
            'blueprint' => '425fb661-0016-4b60-871a-7e23de50027b'
        ],
    ];

    /**
     * @var array hasMany relations, where offers start the three level nested relation controller
     */
    public $hasMany = [
        'offers' => [ProductOffer::class, 'delete' => true]
    ];

    /**
     * @var array attachOne relations
     */
    public $attachOne = [
        'certificate' => \System\Models\File::class
    ];

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        'gallery' => \System\Models\File::class
    ];

    /**
     * filterFields limits the prices repeater to one item unless bulk pricing is turned on.
     */
    public function filterFields($fields)
    {
        if ($fields->prices && $fields->bulk_pricing) {
            if ($fields->bulk_pricing->value) {
                $fields->prices->maxItems = 0;
            }
            else {
                $fields->prices->maxItems = 1;
                $fields->prices->value = array_slice((array) $fields->prices->value, 0, 1, true);
            }
        }
    }

    /**
     * getBulkDropdownOptions returns options that change with bulk_pricing, testing an explicit options method.
     */
    public function getBulkDropdownOptions($value, $fieldName, $data)
    {
        if ($this->bulk_pricing) {
            return [
                0 => 'Bulk Enabled',
                1 => 'Enabled bulk',
                2 => 'enabled'
            ];
        }

        return [
            0 => 'Bulk Disabled',
            1 => 'Disabled bulk',
            2 => 'disabled'
        ];
    }
}
