<?php namespace October\Test\Updates;

use October\Test\Models\Job;
use October\Rain\Database\Updates\Seeder;


class SeedJobTables extends Seeder
{

    public function run()
    {
        Job::create(['parent_id' => 0, 'user_id' => 1, 'name' => 'Job 000']);
        Job::create(['parent_id' => 1, 'user_id' => 2, 'name' => 'Job 010']);
        Job::create(['parent_id' => 0, 'user_id' => 1, 'name' => 'Job 100']);
        Job::create(['parent_id' => 2, 'user_id' => 2, 'name' => 'Job 110']);
        Job::create(['parent_id' => 3, 'user_id' => 1, 'name' => 'Job 111']);
        Job::create(['parent_id' => 3, 'user_id' => 2, 'name' => 'Job 112']);
    }

}
