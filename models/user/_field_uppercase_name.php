<?php /* Testing a partial field that copies the core text field and attaches a control to it */ ?>
<?php if ($this->previewMode): ?>
    <span class="form-control"><?= $field->value ? e($field->value) : '&nbsp;' ?></span>
<?php else: ?>
    <input
        type="text"
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        value="<?= e($field->value) ?>"
        placeholder="<?= e(__($field->placeholder)) ?>"
        class="form-control"
        autocomplete="off"
        data-control="uppercase-input"
        <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
        <?= $field->getAttributes() ?>
    />
<?php endif ?>
