<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('october/test/companies') ?>">Companies</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($this->pageTitle) ?></li>
    </ol>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout']) ?>

        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>

        <h5>All Icons</h5>
        <div class="form-preview">
            <div class="row text-center">
                <?php foreach (\System\Helpers\Preset::icons() as $icon): ?>
                    <div class="col-1">
                        <h1 title="<?= $icon[1] ?>"><i class="<?= $icon[1] ?>"></i></h1>
                        <small><?= $icon[1] ?></small>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="form-buttons">
            <div class="loading-indicator-container">
                <button
                    type="submit"
                    data-request="onSave"
                    data-request-data="redirect:0"
                    data-hotkey="ctrl+s, cmd+s"
                    data-load-indicator="<?= e(trans('backend::lang.form.saving_name', ['name'=>$formRecordName])) ?>"
                    class="btn btn-primary">
                    <?= e(trans('backend::lang.form.save')) ?>
                </button>
                <button
                    type="button"
                    data-request="onSave"
                    data-request-data="close:1"
                    data-browser-redirect-back
                    data-hotkey="ctrl+enter, cmd+enter"
                    data-load-indicator="<?= e(trans('backend::lang.form.saving_name', ['name'=>$formRecordName])) ?>"
                    class="btn btn-default">
                    <?= e(trans('backend::lang.form.save_and_close')) ?>
                </button>
                <button
                    type="button"
                    class="oc-icon-trash-o btn-icon danger pull-right"
                    data-request="onDelete"
                    data-load-indicator="<?= e(trans('backend::lang.form.deleting_name', ['name'=>$formRecordName])) ?>"
                    data-request-confirm="<?= e(trans('backend::lang.form.confirm_delete')) ?>">
                </button>
                <span class="btn-text">
                    <?= e(trans('backend::lang.form.or')) ?> <a href="<?= Backend::url('october/test/companies') ?>"><?= e(trans('backend::lang.form.cancel')) ?></a>
                </span>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('october/test/companies') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')) ?></a></p>

<?php endif ?>
