<?php /* Backend::dateTime returns an escaped <time> element, so it is echoed without e() */ ?>
<span>
    <?= __("The current time is:") ?>
</span>
<strong><?= $currentTime ?></strong>
