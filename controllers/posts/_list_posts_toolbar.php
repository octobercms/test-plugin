<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Post"),
        href: Backend::url('october/test/posts/create'),
        icon: 'ph ph-plus',
        primary: true
    ) ?>

    <?= Ui::button(
        label: __("Export Posts"),
        href: Backend::url('october/test/posts/export'),
        icon: 'ph ph-download-simple',
        secondary: true
    ) ?>
</div>
