<span data-control="order-item-picker">
    <?= Ui::popupButton(
        label: __("Add Product"),
        handler: 'onRelationButtonLink',
        icon: 'ph ph-list-plus',
        secondary: true,
        requestData: ['_relation_field' => 'items[product]'],
        class: 'btn-sm relation-button-link',
        dataSize: $this->popupSize
    ) ?>
</span>
