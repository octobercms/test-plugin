/*
 * OrderItemPicker opens the order item form for the product picked in the items[product] relation list.
 */
oc.registerControl('order-item-picker', class extends oc.ControlBase {
    connect() {
        // The product list renders in a popup appended to the page body
        this.listen('order-item-picker:pick', document.body, this.onPickProduct);
    }

    onPickProduct(event) {
        $('#relationManagePopup').popup('hide');

        $(this.element).popup({
            handler: 'onRelationButtonCreate',
            size: 'huge',
            extraData: {
                manage_id: null,
                product_id: event.detail.productId
            }
        });
    }
});
