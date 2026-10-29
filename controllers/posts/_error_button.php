<?php /* Testing an AJAX request to a handler that does not exist on purpose, which shows the handler not found error */ ?>
<?= Ui::ajaxButton(
    label: __("Do not click"),
    handler: 'onNothing',
    secondary: true
) ?>
