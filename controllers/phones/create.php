<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/phones') ?>"><?= __("Phones") ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>
    <?php Block::put('form:before-form') ?>
        <?= $this->makePartial('form_toggle') ?>
    <?php Block::endPut() ?>
<?php endif ?>

<?= $this->formRenderDesign() ?>
