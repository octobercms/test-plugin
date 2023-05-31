<div data-control="toolbar">
    <a
        href="<?= Backend::url('october/test/products/create') ?>"
        class="btn btn-primary oc-icon-plus">
        <?= e(trans('backend::lang.list.create_button', ['name'=>'Product'])) ?>
    </a>

    <button
        class="btn btn-danger oc-icon-trash-o"
        data-request="onDelete"
        data-list-checked-trigger
        data-list-checked-request
        data-stripe-load-indicator>
        <?= e(trans('backend::lang.list.delete_selected')) ?>
    </button>

    <a
        href="<?= Backend::url('october/test/productcategories') ?>"
        class="btn btn-default oc-icon-database">
        Manage Categories
    </a>

    <a
        href="<?= Backend::url('october/test/companies') ?>"
        class="btn btn-default oc-icon-database">
        Manage Companies
    </a>
</div>
