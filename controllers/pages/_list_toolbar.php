<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Page"),
        href: Backend::url('october/test/pages/create'),
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
        label: __("Export Records"),
        href: Backend::url('october/test/pages/export'),
        icon: 'ph ph-download-simple',
        secondary: true
    ) ?>

    <?= Ui::button(
        label: __("Import Records"),
        href: Backend::url('october/test/pages/import'),
        icon: 'ph ph-upload-simple',
        secondary: true
    ) ?>
</div>
