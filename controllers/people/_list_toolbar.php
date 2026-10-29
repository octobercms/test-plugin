<div data-control="toolbar">
    <?= Ui::button(
        label: __("New Person"),
        href: Backend::url('october/test/people/create'),
        icon: 'ph ph-plus',
        primary: true
    ) ?>

    <div class="toolbar-divider"></div>

    <?= Ui::button(
        label: __("Manage Phones"),
        href: Backend::url('october/test/phones'),
        icon: 'ph ph-phone',
        secondary: true
    ) ?>

    <?php /* Testing AJAX responses: a download or prompt, a modal popup, sending mail and a custom error handler */ ?>
    <?= Ui::popupButton(
        label: __("Download or Prompt"),
        handler: 'onDownloadOrPrompt',
        icon: 'ph ph-shuffle',
        secondary: true,
        dataRequestDownload: true,
        dataBrowserTarget: '_blank'
    ) ?>

    <?= Ui::popupButton(
        label: __("Show Modal Popup"),
        handler: 'onModalShowTest',
        icon: 'ph ph-browser',
        secondary: true,
        dataSize: 'huge'
    ) ?>

    <?= Ui::ajaxButton(
        label: __("Send Test Email"),
        handler: 'onSendTestEmail',
        icon: 'ph ph-envelope-simple',
        secondary: true
    ) ?>

    <?php /* Testing a request error handler that reads custom data from an AjaxException */ ?>
    <?= Ui::ajaxButton(
        label: __("Show Error Message"),
        handler: 'onShowAjaxError',
        icon: 'ph ph-warning',
        danger: true,
        dataRequestError: 'alert(data.messageFromData)'
    ) ?>
</div>
