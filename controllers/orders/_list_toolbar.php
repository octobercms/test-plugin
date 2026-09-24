<div data-control="toolbar">
    <a
        href="<?= Backend::url('october/test/orders/create') ?>"
        class="btn btn-primary oc-icon-plus">
        <?= e(trans('backend::lang.list.create_button', ['name'=>'Order'])) ?>
    </a>

    <a href="javascript;:"
       data-control="popup"
       data-handler="onModelShowAddDatabaseColumnsPopup"
       data-stripe-load-indicator
       class="btn btn-default oc-icon-table">
        Show Data Table
    </a>

    <button
        class="btn btn-danger oc-icon-trash-o"
        data-request="onDelete"
        data-list-checked-trigger
        data-list-checked-request
        data-stripe-load-indicator>
        <?= e(trans('backend::lang.list.delete_selected')) ?>
    </button>
</div>
