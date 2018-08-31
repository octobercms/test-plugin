<?php namespace October\Test\Updates;

use October\Rain\Database\Updates\Seeder;
use October\Test\Models\Page;
use October\Test\Models\Content;

class SeedPagesTables extends Seeder
{
    public function run()
    {
        Page::create([
            'content' => Content::create([
                'title' => 'Demo Page',
                'body'  => '<p>Please edit me then try to save</p>',
            ]),
        ]);
    }
}