<?php namespace October\Test\Models;

use Model;

/**
 * ProductOfferStockLead Model
 */
class ProductOfferStockLead extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table used by the model.
     */
    public $table = 'october_test_product_offer_stock_leads';

    /**
     * @var array rules
     */
    public $rules = [
        'name' => 'required',
    ];

    public $attachMany = [
        'gallery' => \System\Models\File::class
    ];
}
