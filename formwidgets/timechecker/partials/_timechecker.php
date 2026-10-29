<div class="form-preview">
    <div id="<?= $this->getId('container') ?>" class="mb-3">
        <?= $this->makePartial('current_time') ?>
    </div>

    <?= Ui::ajaxButton(
        label: __("Push random time"),
        handler: $this->getEventHandler('onPushUpdateTime'),
        primary: true
    ) ?>

    <?= Ui::ajaxButton(
        label: __("Pull big image (widget)"),
        handler: $this->getEventHandler('onPullImage'),
        primary: true,
        requestData: ['size' => '300x300'],
        dataRequestUpdate: "big_image: '#".$this->getId('container')."'"
    ) ?>

    <?= Ui::ajaxButton(
        label: __("Pull small image (controller)"),
        handler: $this->getEventHandler('onPullImage'),
        primary: true,
        dataRequestUpdate: "small_image: '#".$this->getId('container')."'"
    ) ?>
</div>
