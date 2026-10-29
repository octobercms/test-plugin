<?php /* Testing the Ui factory helpers, where every button and search input calls onShowcaseAction */ ?>
<h5><?= __("All UI") ?></h5>
<div class="form-preview">
    <h6><?= __("Button") ?></h6>
    <div class="mb-4">
        <?= Ui::button(
            label: __("Return Home"),
            href: '/',
            icon: 'ph ph-house'
        ) ?>
    </div>

    <h6><?= __("AJAX Button") ?></h6>
    <div class="mb-4" data-control="loader-container">
        <?= Ui::ajaxButton(
            label: __("Run Action"),
            handler: 'onShowcaseAction',
            primary: true,
            dataRequestMessage: __("Processing...")
        ) ?>
    </div>

    <h6><?= __("Callout") ?></h6>
    <?= Ui::callout(function() { ?>
        <p><?= __("There is something missing here.") ?></p>
    <?php }) ?>

    <h6><?= __("Callout with Button") ?></h6>
    <?= Ui::callout()
        ->danger()
        ->label(__("You may need to do something"))
        ->action(Ui::ajaxButton(
            label: __("Do Something"),
            handler: 'onShowcaseAction',
            danger: true
        ))
    ?>

    <h6><?= __("Search Input") ?></h6>
    <div class="row mb-4">
        <div class="col-6">
            <?= Ui::searchInput(
                name: 'search_term',
                placeholder: __("Search...")
            ) ?>
        </div>
        <div class="col-6">
            <?= Ui::searchInput(
                name: 'search_term_ajax',
                placeholder: __("Search with AJAX..."),
                handler: 'onShowcaseAction'
            ) ?>
        </div>
    </div>
</div>
