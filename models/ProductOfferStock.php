<?php namespace October\Test\Models;

use Model;

/**
 * ProductOfferStock Model
 */
class ProductOfferStock extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table used by the model.
     */
    public $table = 'october_test_product_offer_stocks';

    /**
     * @var array rules
     */
    public $rules = [
        'name' => 'required',
    ];

    public $hasMany = [
        'leads' => [ProductOfferStockLead::class, 'key' => 'stock_id', 'delete' => true]
    ];

    public $attachMany = [
        'gallery' => \System\Models\File::class
    ];
}
