<?php /* Testing a popup returned by a handler that can also answer with a file download, see People::onDownloadOrPrompt */ ?>
<?= Form::open() ?>
    <div class="modal-header">
        <h4 class="modal-title"><?= __("Server Busy") ?></h4>
        <button type="button" class="btn-close" data-dismiss="popup"></button>
    </div>
    <div class="modal-body">
        <div class="pos-r">
            <p><?= __("Server is busy, try again in a moment...") ?></p>
        </div>
    </div>
    <div class="modal-footer">
        <?= Ui::button(
            label: __("Close"),
            secondary: true,
            dataDismiss: 'popup'
        ) ?>
    </div>
<?= Form::close() ?>
