<div class="row gx-0">
    <div class="col-md-4">
        <?= $this->listRender('members') ?>
    </div>
    <div class="col-md-4">
        <?= $this->listRender('categories') ?>
    </div>
    <div class="col-md-4">
        <?= $this->listRender('channels') ?>

        <?php /* Testing soft delete restore, the trashed channels list links to the channel update page that shows the restore button */ ?>
        <div class="padded-container">
            <div class="callout callout-info">
                <div class="header">
                    <i class="ph ph-trash"></i>
                    <h3><?= __("Trashed Channels") ?></h3>
                    <p><?= __("Open a trashed channel to restore it.") ?></p>
                </div>
            </div>
        </div>

        <?= $this->listRender('trashed_channels') ?>
    </div>
</div>
