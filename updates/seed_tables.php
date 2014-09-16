<?php namespace October\Test\Updates;

use October\Rain\Database\Updates\Seeder;
use October\Test\Models\Person;
use October\Test\Models\Phone;
use October\Test\Models\Post;

class SeedAllTables extends Seeder
{

    public function run()
    {
        /*
         * Test 1: People
         */

        $person = Person::create(['name' => 'Eddie Valiant', 'bio' => 'I have a phone set up already']);
        $person->phone = Phone::create(['name' => 'Mobile', 'number' => '(360) 733-2263']);
        $person->alt_phone = Phone::create(['name' => 'Home', 'number' => '(360) 867-3563']);
        $person->save();

        Person::create(['name' => 'Baby Herman', 'bio' => 'I have nothing at all']);
        Phone::create(['name' => 'Work', 'number' => '(360) 595-2146']);
        Phone::create(['name' => 'Fax', 'number' => '(360) 595-2146']);

        /*
         * Test 2: Posts
         */

        Post:: create(['name' => 'First post, yay!', 'content' => 'I have some comments!' ]);
        Post:: create(['name' => 'A lonely toon', 'content' => 'I have nothing at all' ]);
    }

}
