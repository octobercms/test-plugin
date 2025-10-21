<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <?php if (!isset($error)): ?>
        <p>This is the default partial content.</p>
        <p>Title: <?= $this->property('title') ?></p>
        <p>Days: <?= $this->property('days') ?></p>
        <button data-request="<?= $this->getEventHandler('onClearCache') ?>" class="btn btn-outline-warning">
            <span class="fa icon-trash"></span> Clear Cache</button>
    <?php else: ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>
</div>
