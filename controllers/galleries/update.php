<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('october/test/galleries') ?>">Galleries</a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout', 'data-change-monitor' => true]) ?>

        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>

        <div class="form-buttons">
            <div class="loading-indicator-container">
                <button
                    type="submit"
                    data-request="onSave"
                    data-browser-validate
                    data-request-data="redirect:0"
                    data-hotkey="ctrl+s, cmd+s"
                    data-load-indicator="Saving Gallery..."
                    class="btn btn-primary">
                    <u>S</u>ave
                </button>
                <button
                    type="button"
                    data-request="onSave"
                    data-browser-validate
                    data-request-data="close:1"
                    data-hotkey="ctrl+enter, cmd+enter"
                    data-load-indicator="Saving Gallery..."
                    class="btn btn-default">
                    Save and Close
                </button>
                <button
                    type="button"
                    class="oc-icon-trash-o btn-icon danger pull-right"
                    data-request="onDelete"
                    data-load-indicator="Deleting Gallery..."
                    data-request-confirm="Delete this gallery?">
                </button>
                <span class="btn-text">
                    or <a href="<?= Backend::url('october/test/galleries') ?>">Cancel</a>
                </span>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('october/test/galleries') ?>" class="btn btn-default">Return to galleries list</a></p>

<?php endif ?>
