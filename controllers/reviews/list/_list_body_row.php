<tr class="<?= $this->getRowClass($record) ?>">
    <?php if ($showCheckboxes): ?>
        <?= $this->makePartial('list_body_checkbox', ['record' => $record]) ?>
    <?php endif ?>

    <?php $index = $action = 0; $total = count($columns); foreach ($columns as $key => $column): ?>
        <?php
            $index++;
            $classes = [
                'list-cell-index-'.$index,
                'list-cell-name-'.$column->getName(),
                'list-cell-type-'.$column->type,
                $column->getAlignClass(),
                $column->cssClass
            ];

            if (!$column->clickable) {
                $classes[] = 'nolink';
            }
        ?>
        <td class="<?= implode(' ', $classes) ?>">
            <?php if ($index === 1): ?>
                <?php /* Testing customViewPath, this icon is the only change from the core list_body_row partial */ ?>
                <i class="ph ph-smiley"></i>
            <?php endif ?>
            <?php if ($column->clickable && !$action && ($action = $this->getRecordAction($record))): ?>
                <a <?= $action[1] ?> href="<?= $action[0] ?>">
                    <?= $this->getColumnValue($record, $column) ?>
                </a>
            <?php else: ?>
                <?= $this->getColumnValue($record, $column) ?>
            <?php endif ?>
        </td>
    <?php endforeach ?>
</tr>
