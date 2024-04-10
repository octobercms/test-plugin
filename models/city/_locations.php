<?php if ($this->relationHasField('locations')): ?>
    <?= $this->relationRender('locations') ?>
<?php else: ?>
    <p>This relation cannot be managed here</p>
<?php endif ?>
