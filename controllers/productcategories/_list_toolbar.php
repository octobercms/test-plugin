<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Product Category"),
        href: Backend::url('october/test/productcategories/create'),
        icon: 'ph ph-plus',
        primary: true
    ) ?>

    <div class="toolbar-divider"></div>

    <?= Ui::ajaxButton(
        label: __("Delete Selected"),
        handler: 'onDelete',
        icon: 'ph ph-trash',
        secondary: true,
        dataRequestConfirm: __("Delete the selected records?"),
        dataListCheckedTrigger: true,
        dataListCheckedRequest: true,
        disabled: true
    ) ?>
</div>
