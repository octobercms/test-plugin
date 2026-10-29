<?php /* Testing modal focus capture and horizontal overflow for a datatable in a popup, where the columns are deliberately wider than the modal */ ?>
<?= Form::open() ?>
    <div class="modal-header">
        <h4 class="modal-title"><?= __("Data Table In Modal") ?></h4>
        <button type="button" class="btn-close" data-dismiss="popup"></button>
    </div>

    <div class="modal-body">
        <div class="pos-r mb-3">
            <?= $datatable->render() ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Ui::button(
            label: __("Apply"),
            primary: true,
            dataDismiss: 'popup'
        ) ?>

        <?= Ui::button(
            label: __("Cancel"),
            secondary: true,
            dataDismiss: 'popup'
        ) ?>
    </div>
<?= Form::close() ?>
