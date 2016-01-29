<?php namespace October\Test\Models;

use Model;

class AlertSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'october_test';

    public $settingsFields = 'fields.yaml';
}
