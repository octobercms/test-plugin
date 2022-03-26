<div class="filter-box">
    <div class="filter-facet">
        <div class="facet-item is-grow">
            <select name="Filter[value]" class="form-control custom-select <?= $allowSearch ? '' : 'select-no-search' ?> input-sm">
                <option value="1" <?= $scope->value === '1' ? 'selected="selected"' : '' ?>>has a discount</option>
                <option value="0" <?= $scope->value === '0' ? 'selected="selected"' : '' ?>>does not have a discount</option>
            </select>
        </div>
    </div>
    <div class="filter-buttons">
        <button class="btn btn-xs btn-primary" data-filter-action="apply">
            Apply
        </button>
        <div class="flex-grow-1"></div>
        <button class="btn btn-xs btn-secondary" data-filter-action="clear">
            Clear
        </button>
    </div>
</div>
