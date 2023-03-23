<?php namespace October\Test\Models;

use System\Models\SettingModel;

/**
 * Setting model
 */
class Setting extends SettingModel
{
    // use \October\Rain\Database\Traits\Multisite;
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
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
