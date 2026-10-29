<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Order"),
        href: Backend::url('october/test/orders/create'),
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

    <?php /* Testing a datatable widget built in code and shown in a popup */ ?>
    <?= Ui::popupButton(
        label: __("Show Data Table"),
        handler: 'onLoadDataTablePopup',
        icon: 'ph ph-table',
        secondary: true
    ) ?>
</div>
