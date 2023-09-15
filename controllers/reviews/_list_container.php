<?php if ($toolbar): ?>
    <?= $toolbar->render() ?>
<?php endif ?>

<?php if ($filter): ?>
    <?= $filter->render() ?>
<?php endif ?>

<div class="ps-4">
    <div class="row gx-0">
        <div class="col-sm-3">
            <?= $this->makePartial('list_tabs') ?>
        </div>
        <div class="col-sm-9">
            <div class="layout-row">
                <div class="list-widget-container">
                    <?= $list->render() ?>
                </div>
            </div>
        </div>
    </div>
</div>
