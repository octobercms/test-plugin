<?php /* Testing a hand built layout that puts the secondary tabs in a sidebar, the design equivalent is displayMode: sidebar */ ?>
<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/pages') ?>"><?= __("Pages") ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?php Block::put('form-contents') ?>
        <div class="callout callout-warning">
            <div class="header">
                <i class="ph ph-database"></i>
                <h3><?= __("Page model with a type and jsonable content field.") ?></h3>
                <p><?= __("Depending on the type different schemas are saved inside of content.") ?></p>
            </div>
        </div>

        <div class="flex-grow-1">
            <?= $this->formRenderOutsideFields(['useContainer' => false]) ?>
            <?= $this->formRenderPrimaryTabs(['useContainer' => false]) ?>
        </div>

        <div class="form-buttons pt-3">
            <div data-control="loader-container">
                <?= $this->formRender(['section' => 'buttons']) ?>
            </div>
        </div>
    <?php Block::endPut() ?>

    <?php Block::put('form-sidebar') ?>
        <div class="hide-tabs">
            <?= $this->formRenderSecondaryTabs(['useContainer' => false]) ?>
        </div>
    <?php Block::endPut() ?>

    <?php Block::put('body') ?>
        <?= Form::open(['class' => 'position-relative h-100']) ?>
            <div
                id="<?= $this->formGetId() ?>"
                data-control="formwidget"
                data-refresh-handler="<?= $this->formGetWidget()->getEventHandler('onRefresh') ?>"
                class="form-widget form-elements"
                role="form">
                <?= $this->makeLayout('form-with-sidebar') ?>
            </div>
        <?= Form::close() ?>
    <?php Block::endPut() ?>

<?php else: ?>

    <?= $this->formRenderDesign() ?>

<?php endif ?>
