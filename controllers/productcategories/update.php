<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/productcategories') ?>"><?= __("Product Categories") ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?php Block::put('form:after-form') ?>
    <?= $this->makePartial('ui_showcase') ?>
<?php Block::endPut() ?>

<?= $this->formRenderDesign() ?>
