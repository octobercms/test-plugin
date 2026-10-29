<?php namespace October\Test\Models;

use Model;

/**
 * ProductOffer Model
 */
class ProductOffer extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'october_test_product_offers';

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
        'stocks' => [ProductOfferStock::class, 'key' => 'offer_id', 'delete' => true]
    ];
}
