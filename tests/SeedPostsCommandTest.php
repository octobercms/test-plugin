<?php namespace October\Test\Tests;

use Artisan;
use PluginTestCase;
use October\Test\Models\Post;
use October\Test\Models\Comment;

/**
 * SeedPostsCommandTest checks the test:seed-posts console command.
 */
class SeedPostsCommandTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testCommandCreatesPostsWithComments checks the count option and the four comments per post.
     */
    public function testCommandCreatesPostsWithComments()
    {
        $postCount = Post::count();
        $commentCount = Comment::count();

        $exitCode = Artisan::call('test:seed-posts', ['--count' => 3]);

        $this->assertEquals(0, $exitCode);
        $this->assertEquals($postCount + 3, Post::count());
        $this->assertEquals($commentCount + 12, Comment::count());

        $post = Post::orderBy('id', 'desc')->first();
        $this->assertStringEndsWith('.', $post->name);
        $this->assertCount(4, $post->comments);
    }
}
