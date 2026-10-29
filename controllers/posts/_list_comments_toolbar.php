<div data-control="toolbar">
    <?= Ui::popupButton(
        label: __("New Comment"),
        handler: 'onLoadCreateForm',
        icon: 'ph ph-plus',
        primary: true,
        requestData: ['comment_mode' => 1]
    ) ?>
</div>
