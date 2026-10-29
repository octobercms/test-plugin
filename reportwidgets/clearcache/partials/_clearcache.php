<div class="report-widget">
    <h3>
        <?= e($this->property('title')) ?>
    </h3>

    <p>
        <?= __("Title (prop)") ?>: <?= e($this->property('title')) ?>
    </p>
    <p>
        <?= __("Days (prop)") ?>: <?= e($this->property('days')) ?>
    </p>
    <p>
        <?= __("User (prop)") ?>: <?= e($this->property('user')) ?>
    </p>
    <p>
        <?= __("Users (prop)") ?>: <?= e(implode(', ', (array) $this->property('users'))) ?>
    </p>

    <?= Ui::ajaxButton(
        label: __("Clear Cache"),
        handler: $this->getEventHandler('onClearCache'),
        icon: 'ph ph-trash',
        class: 'btn-outline-warning'
    ) ?>

    <?php /* Testing an AJAX handler called from inside a form, while the button above has no form */ ?>
    <form>
        <?= Ui::ajaxButton(
            label: __("AJAX Test"),
            handler: $this->getEventHandler('onTestAjax'),
            class: 'btn-outline-info'
        ) ?>
    </form>

    <p id="<?= $this->getId('testResult') ?>"></p>
</div>
