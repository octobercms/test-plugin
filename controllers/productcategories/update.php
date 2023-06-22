<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('october/test/productcategories') ?>">Product Categories</a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout']) ?>

        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>

        <h5>All UI</h5>
        <div class="form-preview">
            <h6>Button</h6>
            <div class="mb-4">
                <?= Ui::button('Return Home', '/') ?>
            </div>

            <h6>Form Toolbar</h6>
            <?= Ui::formToolbar(
                Ui::ajaxButton('Delete Record', 'onDeleteRecord')
                    ->loadingMessage('Processing...')
                    ->primary()
            ) ?>

            <h6>Callout</h6>
            <?= Ui::callout(function() { ?>
                <p>There is something missing here.</p>
            <?php }) ?>

            <h6>Callout with Button</h6>
            <?= Ui::callout()
                ->danger()
                ->label('You may need to do something')
                ->action(
                    Ui::popupButton('Do Something', 'onDoSomething')
                        ->danger()
                        ->loading()
                )
            ?>

            <h6>Search Input</h6>
            <div class="row">
                <div class="col-6">
                    <?= Ui::searchInput('Search...', 'search_term') ?>
                </div>
                <div class="col-6">
                    <?= Ui::searchInput('Search with AJAX...', 'search_term_ajax')->ajaxHandler('onAjax') ?>
                </div>
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
                    <?= e(trans('backend::lang.form.or')) ?> <a href="<?= Backend::url('october/test/productcategories') ?>"><?= e(trans('backend::lang.form.cancel')) ?></a>
                </span>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('october/test/productcategories') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')) ?></a></p>

<?php endif ?>
