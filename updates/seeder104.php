<?php namespace October\Test\Updates;

use Illuminate\Support\Str;
use October\Rain\Database\Updates\Seeder;
use October\Test\Models\Channel;

class Seeder104 extends Seeder
{
	public function run(): void
	{
		$parent = Channel::create(['title' => 'PARENT', 'description' => Str::random(30)]);
		$parent2 = Channel::create(['title' => 'PARENT_TWO', 'description' => Str::random(30), 'parent_id' => $parent->id]);
		Channel::create(['title' => 'CHILD_SEARCH', 'parent_id' => $parent2->id]);
	}
}