<?php namespace October\Test\Tests;

use Request;
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

    public function testItPosts()
    {
        Request::setMethod('POST');
        Request::merge(['checked' => [1,2,3]]);
        $this->assertEquals([1,2,3], post('checked'));
    }
}
