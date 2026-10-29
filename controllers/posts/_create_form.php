<?= Form::open(['id' => 'createForm']) ?>

    <?php /* Testing a mode flag posted with every request, so the constructor picks the comment or tag form config */ ?>
    <?php if ($mode == 'comment'): ?>
        <input type="hidden" name="comment_mode" value="1" />
    <?php elseif ($mode == 'tag'): ?>
        <input type="hidden" name="tag_mode" value="1" />
    <?php endif ?>

    <div class="modal-header">
        <h4 class="modal-title"><?= e(__("Create :name", ['name' => $formRecordName])) ?></h4>
        <button type="button" class="btn-close" data-dismiss="popup"></button>
    </div>

    <?php if (!$this->fatalError): ?>

        <div class="modal-body">
            <?= $this->formRender() ?>
        </div>
        <div class="modal-footer">
            <?= Ui::ajaxButton(
                label: __("Create"),
                handler: 'onCreateRecord',
                primary: true,
                hotkey: ['ctrl+s', 'cmd+s'],
                type: 'submit',
                dataPopupLoadIndicator: true
            ) ?>

            <?= Ui::button(
                label: __("Cancel"),
                secondary: true,
                dataDismiss: 'popup'
            ) ?>
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

<?= Form::close() ?>
