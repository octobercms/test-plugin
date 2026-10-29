<?php /* Testing the icon presets, rendering every icon in the icons preset and in the icons@phosphor preset */ ?>
<h5><?= __("All Icons") ?></h5>
<div class="form-preview mb-4">
    <div class="row text-center">
        <?php foreach (\System\Helpers\Preset::icons() as $icon): ?>
            <div class="col-1">
                <h1 title="<?= e($icon[1]) ?>"><i class="<?= e($icon[1]) ?>"></i></h1>
                <small><?= e($icon[1]) ?></small>
            </div>
        <?php endforeach ?>
    </div>
</div>

<h5><?= __("All Phosphor Icons") ?></h5>
<div class="form-preview">
    <div class="row text-center">
        <?php foreach (\System\Classes\PresetManager::instance()->getPreset('icons@phosphor') as $icon): ?>
            <div class="col-1">
                <h1 title="<?= e($icon[1]) ?>"><i class="<?= e($icon[1]) ?>"></i></h1>
                <small><?= e($icon[1]) ?></small>
            </div>
        <?php endforeach ?>
    </div>
</div>
