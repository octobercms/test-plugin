<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Product"),
        href: Backend::url('october/test/products/create'),
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

    <?= Ui::button(
        label: __("Manage Orders"),
        href: Backend::url('october/test/orders'),
        icon: 'ph ph-database',
        secondary: true
    ) ?>

    <?= Ui::button(
        label: __("Manage Categories"),
        href: Backend::url('october/test/productcategories'),
        icon: 'ph ph-database',
        secondary: true
    ) ?>

    <?= Ui::button(
        label: __("Manage Companies"),
        href: Backend::url('october/test/companies'),
        icon: 'ph ph-database',
        secondary: true
    ) ?>
</div>
