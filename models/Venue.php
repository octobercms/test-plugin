<?php namespace October\Test\Models;
use Model;

class Venue extends Model
{
    public $table = 'october_test_venues';
    public $timestamps = false;
    public $attachOne = [
        'cafeinfo' => 'October\Test\Models\Fragment',
        'parkinginfo' => 'October\Test\Models\Fragment',
        'additionalinfo' => 'October\Test\Models\Fragment'
    ];

    public $fillable = ['field','data'];

}