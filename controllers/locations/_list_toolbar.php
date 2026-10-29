<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Location"),
        href: Backend::url('october/test/locations/create'),
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
        label: __("Manage Countries"),
        href: Backend::url('october/test/countries'),
        icon: 'ph ph-database',
        secondary: true
    ) ?>

    <?= Ui::button(
        label: __("Manage Cities"),
        href: Backend::url('october/test/cities'),
        icon: 'ph ph-database',
        secondary: true
    ) ?>
</div>
