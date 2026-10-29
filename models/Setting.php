<?php namespace October\Test\Models;

use System\Models\SettingModel;

/**
 * Setting Model
 */
class Setting extends SettingModel
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Translatable;

    /**
     * @var array translatable attributes stored per locale
     */
    public $translatable = ['title', 'footer'];

    /**
     * @var string settingsCode unique code for these settings
     */
    public $settingsCode = 'october_test_settings';

    /**
     * @var string settingsFields form definitions in the model directory
     */
    public $settingsFields = 'fields.yaml';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'title' => 'required',
        'show_all_tests' => 'boolean',
    ];
}
