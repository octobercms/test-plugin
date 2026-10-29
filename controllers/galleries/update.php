<?php /* Testing browser validation on save together with the change monitor, in a hand built form */ ?>
<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/galleries') ?>"><?= __("Galleries") ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout', 'data-change-monitor' => true]) ?>

        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>

        <div class="form-buttons">
            <div data-control="loader-container">
                <?= Ui::ajaxButton(
                    label: __("Save"),
                    handler: 'onSave',
                    primary: true,
                    hotkey: ['ctrl+s', 'cmd+s'],
                    dataRequestData: "redirect: false",
                    dataBrowserValidate: true,
                    dataChangeMonitorCommit: true
                ) ?>

                <?= Ui::ajaxButton(
                    label: __("Save & Close"),
                    handler: 'onSave',
                    secondary: true,
                    hotkey: ['ctrl+enter', 'cmd+enter'],
                    dataRequestData: "close: true",
                    dataBrowserValidate: true,
                    dataChangeMonitorCommit: true
                ) ?>

                <?= Ui::iconButton(
                    label: __("Delete"),
                    icon: 'ph ph-trash',
                    handler: 'onDelete',
                    danger: true,
                    class: 'pull-right',
                    dataRequestConfirm: __("Delete this record?"),
                    dataChangeMonitorCommit: true
                ) ?>

                <span class="btn-text">
                    <span class="button-separator"><?= __("or") ?></span>
                    <a href="<?= Backend::url('october/test/galleries') ?>"><?= __("Cancel") ?></a>
                </span>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <?= $this->formRenderDesign() ?>

<?php endif ?>
