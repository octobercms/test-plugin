<div class="row">
    <div class="col">
        <input
            type="text"
            name="<?= $field->getName() ?>[first_value]"
            value="<?= e($field->value['first_value'] ?? '') ?>"
            class="form-control"
            style="color: <?= $field->firstColor ?: 'red' ?>"
        />
    </div>
    <div class="col">
        <input
            type="text"
            name="<?= $field->getName() ?>[second_value]"
            value="<?= e($field->value['second_value'] ?? '') ?>"
            class="form-control"
            style="color: <?= $field->secondColor ?: 'blue' ?>"
        />
    </div>
</div>