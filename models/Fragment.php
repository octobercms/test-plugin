<?php namespace October\Test\Models;
use Model;

class Fragment extends Model
{
    public $table = 'october_test_fragments';
    public $timestamps = false;
    public $morphTo = [
        'attachment' => []
    ];

    public $fillable = ['field','data'];

}