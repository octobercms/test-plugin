<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Rain\Database\ModelException;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\Tag;
use October\Test\Models\Country;
use October\Test\Models\Review;

/**
 * ModelValidationTest validates model validation rules work correctly
 */
class ModelValidationTest extends PluginTestCase
{
    /**
     * setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->migrateDatabase();
    }

    /**
     * testPersonRequiresName
     */
    public function testPersonRequiresName()
    {
        $this->expectException(ModelException::class);

        Person::create(['name' => '']);
    }

    /**
     * testPersonPassesValidation
     */
    public function testPersonPassesValidation()
    {
        $person = Person::create(['name' => 'Valid Person']);

        $this->assertNotNull($person->id);
    }

    /**
     * testPostRequiresName
     */
    public function testPostRequiresName()
    {
        $this->expectException(ModelException::class);

        Post::create(['name' => '']);
    }

    /**
     * testPostPassesValidation
     */
    public function testPostPassesValidation()
    {
        $post = Post::create(['name' => 'Valid Post']);

        $this->assertNotNull($post->id);
    }

    /**
     * testCommentRequiresName
     */
    public function testCommentRequiresName()
    {
        $this->expectException(ModelException::class);

        Comment::create(['name' => '', 'content' => 'No name']);
    }

    /**
     * testCommentPassesValidation
     */
    public function testCommentPassesValidation()
    {
        $comment = Comment::create(['name' => 'Valid Comment', 'content' => 'Some content']);

        $this->assertNotNull($comment->id);
    }

    /**
     * testTagRequiresName
     */
    public function testTagRequiresName()
    {
        $this->expectException(ModelException::class);

        Tag::create(['name' => '']);
    }

    /**
     * testCountryRequiresName
     */
    public function testCountryRequiresName()
    {
        $this->expectException(ModelException::class);

        Country::create(['name' => '', 'code' => 'XX']);
    }

    /**
     * testReviewRequiresFeatureColor
     */
    public function testReviewRequiresFeatureColor()
    {
        $this->expectException(ModelException::class);

        Review::create(['feature_color' => '']);
    }

    /**
     * testReviewPassesValidation
     */
    public function testReviewPassesValidation()
    {
        $review = Review::create(['feature_color' => '#ff0000']);

        $this->assertNotNull($review->id);
    }
}
