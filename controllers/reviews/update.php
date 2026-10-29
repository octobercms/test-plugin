<?php /* Testing a hand built form with the change monitor, where each button commits the tracked changes */ ?>
<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/reviews') ?>"><?= __("Reviews") ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout', 'data-change-monitor' => true]) ?>

        <?php if ($formModel->product): ?>
            <div class="scoreboard">
                <div data-control="toolbar">
                    <div class="scoreboard-item title-value">
                        <h4><?= __("Product") ?></h4>
                        <p><?= e($formModel->product->name) ?></p>
                        <p class="description"><?= __("type: :type", ['type' => e(class_basename($formModel->product))]) ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php /* Testing a review with no product, where the morphTo relation is null */ ?>
            <div class="callout fade show callout-warning no-icon no-subheader">
                <div class="header">
                    <h3><?= __("Orphan detected") ?></h3>
                </div>
                <div class="content">
                    <p><?= __("This review is an orphan") ?></p>
                </div>
            </div>
        <?php endif ?>

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
                    dataChangeMonitorCommit: true
                ) ?>

                <?= Ui::ajaxButton(
                    label: __("Save & Close"),
                    handler: 'onSave',
                    secondary: true,
                    hotkey: ['ctrl+enter', 'cmd+enter'],
                    dataRequestData: "close: true",
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
                    <a href="<?= Backend::url('october/test/reviews') ?>"><?= __("Cancel") ?></a>
                </span>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <?= $this->formRenderDesign() ?>

<?php endif ?>
