<div data-control="toolbar">
    <?= Ui::button(
        label: __("New User"),
        href: Backend::url('october/test/users/create'),
        icon: 'ph ph-plus',
        primary: true
    ) ?>

    <?php /* Testing a select that sends an AJAX request on change */ ?>
    <?= Form::select('period', range(0, 12), 1, [
        'class' => 'form-control custom-select',
        'data-request' => 'onSelectPeriod',
        'data-request-data' => 'foo: "bar"'
    ]) ?>

    <?php /* Testing a select that loads its options from an AJAX handler */ ?>
    <select
        class="form-control custom-select"
        style="width: 200px"
        data-handler="onGetSelectOptions"
        data-minimum-input-length="1"
        data-ajax--delay="300"
        data-request-data="foo: 'bar'">
    </select>
</div>
