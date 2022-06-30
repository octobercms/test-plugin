<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Comment;

class ExampleModelTest extends PluginTestCase
{
    public function testItSaves()
    {
        $model = new Comment();
        $model->name = 'name';
        $model->content = 'content';
        $model->save();

        $model = Comment::find($model->id);
        $this->assertEquals('name', $model->name);
        $this->assertEquals('content', $model->content);
    }
}
