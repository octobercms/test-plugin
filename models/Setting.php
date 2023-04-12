<?php namespace October\Test\Models;

use System\Models\SettingModel;
use October\Rain\Database\Model;

/**
 * Setting model
 */
class Setting extends SettingModel
// class Setting extends Model
{
    // use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        // \System\Behaviors\SettingsModel::class,
        '@'.\RainLab\Translate\Behaviors\TranslatableModel::class
    ];

    protected $propagatable = ['other_title'];

    protected $propagatableSync = true;

    public $translatable = ['title', 'footer'];

    public $settingsCode = 'october_test_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'title' => 'required',
        'show_all_posts' => 'boolean',
    ];
}
