<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Review"),
        href: Backend::url('october/test/reviews/create'),
        icon: 'ph ph-plus',
        primary: true
    ) ?>

    <div class="toolbar-divider"></div>

    <?= Ui::button(
        label: __("Manage Plugins"),
        href: Backend::url('october/test/plugins'),
        icon: 'ph ph-gear',
        secondary: true
    ) ?>

    <?= Ui::button(
        label: __("Manage Themes"),
        href: Backend::url('october/test/themes'),
        icon: 'ph ph-gear',
        secondary: true
    ) ?>
</div>
