<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/pages') ?>"><?= __("Pages") ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?= Form::open(['class' => 'd-flex flex-column h-100']) ?>

    <div class="flex-grow-1">
        <?= $this->exportRender() ?>
    </div>

    <div class="form-buttons">
        <div data-control="loader-container">
            <?= Ui::popupButton(
                label: __("Export Pages"),
                handler: 'onExportLoadForm',
                icon: 'ph ph-download-simple',
                primary: true,
                dataKeyboard: 'false'
            ) ?>
        </div>
    </div>

<?= Form::close() ?>
