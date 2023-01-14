<?php namespace October\Test\Tests;

use Request;
use PluginTestCase;
use October\Test\Models\Comment;

/**
 * ExampleModelTest
 */
class ExampleModelTest extends PluginTestCase
{
    /**
     * testItSaves
     */
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

    /**
     * testItPosts
     */
    public function testItPosts()
    {
        Request::setMethod('POST');
        Request::merge(['checked' => [1,2,3]]);
        $this->assertEquals([1,2,3], post('checked'));
    }
}
