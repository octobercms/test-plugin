<div data-control="toolbar">
    <?= Ui::popupButton(
        label: __("New Tag"),
        handler: 'onLoadCreateForm',
        icon: 'ph ph-plus',
        primary: true,
        requestData: ['tag_mode' => 1]
    ) ?>
</div>
