<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\Tag;
use October\Test\Models\Country;
use October\Test\Models\Channel;
use October\Test\Models\Category;

/**
 * ModelCrudTest validates basic CRUD operations on key models
 */
class ModelCrudTest extends PluginTestCase
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
     * testCreatePerson
     */
    public function testCreatePerson()
    {
        $person = Person::create(['name' => 'Test Person', 'preferred_name' => 'Tester']);

        $this->assertNotNull($person->id);
        $this->assertEquals('Test Person', $person->name);

        $found = Person::find($person->id);
        $this->assertEquals('Test Person', $found->name);
    }

    /**
     * testUpdatePerson
     */
    public function testUpdatePerson()
    {
        $person = Person::create(['name' => 'Original Name']);

        $person->name = 'Updated Name';
        $person->save();

        $found = Person::find($person->id);
        $this->assertEquals('Updated Name', $found->name);
    }

    /**
     * testDeletePerson
     */
    public function testDeletePerson()
    {
        $person = Person::create(['name' => 'Delete Me']);
        $id = $person->id;

        $person->delete();

        $this->assertNull(Person::find($id));
    }

    /**
     * testCreatePost
     */
    public function testCreatePost()
    {
        $post = Post::create(['name' => 'Test Post', 'content_html' => '<p>Content</p>']);

        $this->assertNotNull($post->id);
        $this->assertEquals('Test Post', $post->name);
        $this->assertNotEmpty($post->slug, 'Slug should be auto-generated');
    }

    /**
     * testPostSlugGeneration
     */
    public function testPostSlugGeneration()
    {
        $post = Post::create(['name' => 'My Test Post Title']);

        $this->assertEquals('my-test-post-title', $post->slug);
    }

    /**
     * testCreateComment
     */
    public function testCreateComment()
    {
        $comment = Comment::create(['name' => 'Test Comment', 'content' => 'Comment body']);

        $this->assertNotNull($comment->id);
        $this->assertEquals('Test Comment', $comment->name);
        $this->assertEquals('Comment body', $comment->content);
    }

    /**
     * testCommentSoftDelete
     */
    public function testCommentSoftDelete()
    {
        $comment = Comment::create(['name' => 'Soft Delete Me', 'content' => 'Content']);
        $id = $comment->id;

        $comment->delete();

        $this->assertNull(Comment::find($id));
        $this->assertNotNull(Comment::withTrashed()->find($id));
    }

    /**
     * testCreateTag
     */
    public function testCreateTag()
    {
        $tag = Tag::create(['name' => 'Laravel']);

        $this->assertNotNull($tag->id);
        $this->assertEquals('Laravel', $tag->name);
    }

    /**
     * testTagFullNameAccessor
     */
    public function testTagFullNameAccessor()
    {
        $tag = Tag::create(['name' => 'October']);

        $this->assertEquals('October Grossbard', $tag->full_name);
    }

    /**
     * testCreateCountry
     */
    public function testCreateCountry()
    {
        $country = Country::create(['name' => 'Australia', 'code' => 'AU']);

        $this->assertNotNull($country->id);
        $this->assertEquals('Australia', $country->name);
    }

    /**
     * testCountryCustomAccessor
     */
    public function testCountryCustomAccessor()
    {
        $country = Country::create(['name' => 'Canada', 'code' => 'CA']);

        $this->assertEquals('[Canada]', $country->country_name_custom);
    }

    /**
     * testPersonNullableAttribute
     */
    public function testPersonNullableAttribute()
    {
        $person = Person::create(['name' => 'Nullable Test', 'is_married' => '']);

        $found = Person::find($person->id);
        $this->assertNull($found->is_married);
    }

    /**
     * testPersonJsonableAttributes
     */
    public function testPersonJsonableAttributes()
    {
        $person = Person::create([
            'name' => 'Jsonable Test',
            'hobbies' => ['reading', 'coding'],
            'sports' => ['football'],
        ]);

        $found = Person::find($person->id);
        $this->assertEquals(['reading', 'coding'], $found->hobbies);
        $this->assertEquals(['football'], $found->sports);
    }

    /**
     * testPersonAfterCreateSetsAltId
     */
    public function testPersonAfterCreateSetsAltId()
    {
        $person = Person::create(['name' => 'Alt ID Test']);

        $this->assertEquals($person->id + 100, $person->alt_id);
    }
}
