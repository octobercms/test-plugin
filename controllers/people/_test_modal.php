<?php /* Testing the popup load indicator with and without a confirm, a hotkey stacked over the page, and a popup or download response opened from inside a popup */ ?>
<?= Form::open() ?>
    <div class="modal-header">
        <h4 class="modal-title"><?= __("Test") ?></h4>
        <button type="button" class="btn-close" data-dismiss="popup"></button>
    </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
        <?= Ui::ajaxButton(
            label: __("With confirm"),
            handler: 'onShowFlashMessage',
            primary: true,
            hotkey: ['ctrl+s', 'cmd+s'],
            dataRequestConfirm: __("Test"),
            dataPopupLoadIndicator: true
        ) ?>

        <?= Ui::ajaxButton(
            label: __("Without confirm"),
            handler: 'onShowFlashMessage',
            primary: true,
            dataPopupLoadIndicator: true
        ) ?>

        <?= Ui::popupButton(
            label: __("Download or Prompt"),
            handler: 'onDownloadOrPrompt',
            icon: 'ph ph-shuffle',
            secondary: true,
            dataRequestDownload: true,
            dataPopupLoadIndicator: true
        ) ?>
    </div>
<?= Form::close() ?>
