<?php
    $activeValue = $scope->scopeValue !== null ? $scope->value : $scope->default;
?>
<div
    data-scope-name="<?= $scope->scopeName ?>"
    data-control="balloon-selector"
    data-selector-allow-empty
    class="filter-scope scope-inline control-balloon-selector form-control-sm">
    <ul class="list-unstyled m-0">
        <?php foreach ((array) $scope->options as $key => $value): ?>
            <li
                data-value="<?= e($key) ?>"
                class="small <?= $key === $activeValue ? 'active' : '' ?>"
                data-filter-action="apply">
                <?= e($value) ?>
            </li>
        <?php endforeach ?>
    </ul>
    <!-- Hidden input to store the selected filter value -->
    <input type="hidden" name="<?= $name ?>[value]" value="<?= e($activeValue) ?>">
</div>
