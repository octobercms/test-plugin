<?php namespace October\Test\Models;

use Model;

/**
 * Category Model
 */
class Category extends Model
{
    // Multisite comes before Sortable so site_root_id is set before Sortable writes the sort order on create
    use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_categories';

    /**
     * @var array propagatable attributes to copy to other sites
     */
    protected $propagatable = [];

    /**
     * @var bool|array propagatableSync keeps the record structure the same across all sites
     */
    protected $propagatableSync = true;

    /**
     * @var array rules for validation
     */
    public $rules = [
        'code' => 'unique_site'
    ];
}
