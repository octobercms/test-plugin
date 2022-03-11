<?php namespace October\Test\Models;

use October\Rain\Database\Model;

/**
 * Setting model
 */
class Setting extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        \System\Behaviors\SettingsModel::class,
        '@'.\RainLab\Translate\Behaviors\TranslatableModel::class
    ];

    public $translatable = ['footer'];

    public $settingsCode = 'october_test_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'show_all_posts' => ['boolean'],
    ];
}
