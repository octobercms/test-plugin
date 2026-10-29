<?php namespace October\Test\Models;

use Model;

/**
 * ProductOfferStock Model
 */
class ProductOfferStock extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_product_offer_stocks';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array hasMany relations
     */
    public $hasMany = [
        'leads' => [ProductOfferStockLead::class, 'key' => 'stock_id', 'delete' => true]
    ];

    /**
     * @var array attachMany relations
     */
    public $attachMany = [
        'gallery' => \System\Models\File::class
    ];
}
