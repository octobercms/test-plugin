<?php /* Testing a custom delete popup that posts a reason along with the delete request, see Posts::onDeleteWithReason */ ?>
<?php if (!$this->fatalError): ?>

    <div id="deletePopup">
        <?= Form::open(['id' => 'deleteForm']) ?>
            <div class="modal-header">
                <h4 class="modal-title"><?= __("Please give a reason") ?></h4>
                <button type="button" class="btn-close" data-dismiss="popup"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea
                        name="reason"
                        class="form-control field-textarea size-large"
                        placeholder=""></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <?= Ui::ajaxButton(
                    label: __("Confirm delete"),
                    handler: 'onDeleteWithReason',
                    danger: true,
                    type: 'submit',
                    dataRequestConfirm: __("Do you really want to delete this post?"),
                    dataPopupLoadIndicator: true
                ) ?>

                <?= Ui::button(
                    label: __("Cancel"),
                    secondary: true,
                    dataDismiss: 'popup'
                ) ?>
            </div>
        <?= Form::close() ?>
    </div>

<?php else: ?>

    <div class="modal-body">
        <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    </div>
    <div class="modal-footer">
        <?= Ui::button(
            label: __("Close"),
            secondary: true,
            dataDismiss: 'popup'
        ) ?>
    </div>

<?php endif ?>
