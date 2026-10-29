<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\FormWidgets\DataTable;
use October\Test\Models\Product;

/**
 * Orders Backend Controller
 */
class Orders extends Controller
{
    /**
     * @var array implement extensions
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string relationConfig file
     */
    public $relationConfig = 'config_relation.yaml';

    /**
     * @var array requiredPermissions to view this page
     */
    public $requiredPermissions = ['october.test.manage_products'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        // Orders is a sub-page of Products, opened from the Products toolbar, so it keeps the Products menu item active
        BackendMenu::setContext('October.Test', 'test', 'products');
    }

    /**
     * beforeDisplay adds the control that opens the order item form after a product is picked.
     */
    public function beforeDisplay()
    {
        $this->addJs('/plugins/october/test/assets/js/order-item-picker.js');
    }

    /**
     * relationExtendManageFormWidget fills a new order item from the product picked in the product list.
     */
    public function relationExtendManageFormWidget($widget, $field, $model)
    {
        if (
            $field === 'items' &&
            !$widget->getModel()->exists &&
            ($productId = (int) post('product_id')) &&
            ($product = Product::find($productId))
        ) {
            $widget->getModel()->fillFromProduct($product);
        }
    }

    /**
     * onLoadDataTablePopup renders a datatable widget built in a handler inside a popup, testing modal focus capture and horizontal overflow.
     */
    public function onLoadDataTablePopup()
    {
        $config = $this->makeConfig([
            'toolbar' => false,
            'columns' => [
                'type' => [
                    'title' => 'Widget Type',
                    'type' => 'dropdown',
                    'options' => [
                        'petty' => 'Petty',
                        'minor' => 'Minor',
                        'major' => 'Major',
                        'critical' => 'Critical'
                    ],
                ],
                // Testing horizontal overflow, these 400px columns are deliberately wider than the popup
                'col_a' => [
                    'title' => 'Column A',
                    'width' => 400,
                ],
                'col_b' => [
                    'title' => 'Column B',
                    'width' => 400,
                ],
                'col_c' => [
                    'title' => 'Column C',
                    'width' => 400,
                ],
            ],
        ]);

        $datatable = $this->makeFormWidget(DataTable::class, 'add_database_columns', $config);
        $datatable->alias = 'add_database_columns_datatable';
        $datatable->bindToController();

        return $this->makePartial('datatable_popup', [
            'datatable' => $datatable,
        ]);
    }
}
