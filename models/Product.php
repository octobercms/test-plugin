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
        'title' => 'unique',
        'location_sold' => 'between:0,2'
    ];

    /**
     * @var mixed attributes that aren't mass assignable.
     */
    protected $guarded = false;

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array propagatable list of attributes to propagate to other sites.
     */
    public $propagatable = [
        'title',
        'price',
        'slug',
        'company',
    ];

    /**
     * @var bool propagatableSync will enforce model structures between all sites
     */
    protected $propagatableSync = true;

    /**
     * @var array slugs for these attributes.
     */
    protected $slugs = ['slug' => 'title'];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [
        'prices'
    ];

    /**
     * @var array belongsToMany and other relations
     */
    public $belongsTo = [
        'location_built' => [
            Location::class,
            'key' => 'location_id'
        ],
        'author' => [
            \Tailor\Models\EntryRecord::class,
            'blueprint' => 'e183d98c-e7ef-4142-a5d4-f56b596a9fa3'
        ],
        'company' => [
            Company::class,
            'scope' => 'withTrashed'
        ]
    ];

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
        ],
    ];

    public $hasMany = [
        'offers' => [ProductOffer::class, 'delete' => true]
    ];

    public $attachOne = [
        'certificate' => \System\Models\File::class
    ];

    public $attachMany = [
        'gallery' => \System\Models\File::class
    ];

    /**
     * filterFields
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
}
