<?php
    $activeValue = $scope->scopeValue !== null ? $scope->value : $scope->default;
?>
<div
    class="filter-scope scope-inline"
    data-scope-name="<?= $scope->scopeName ?>">
    <input
        placeholder="<?= e($this->getHeaderValue($scope)) ?>"
        name="Filter[value]"
        value="<?= e($activeValue) ?>"
        class="form-control form-control-sm" />
    <button
        class="btn btn-sm btn-search"
        data-filter-action="apply">
        <i class="icon-search"></i>
    </button>
</div>
