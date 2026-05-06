<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\Tag;
use October\Test\Models\User;
use October\Test\Models\Role;
use October\Test\Models\Country;
use October\Test\Models\City;
use October\Test\Models\Phone;
use October\Test\Models\Review;
use October\Test\Models\Gallery;
use October\Test\Models\Plugin;
use October\Test\Models\Theme;

/**
 * ModelRelationTest validates model relationships work correctly
 */
class ModelRelationTest extends PluginTestCase
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
     * testPersonHasOnePhone
     */
    public function testPersonHasOnePhone()
    {
        $person = Person::create(['name' => 'Phone Owner']);

        $phone = new Phone;
        $phone->name = 'Home Phone';
        $phone->number = '555-1234';
        $phone->person_id = $person->id;
        $phone->is_active = true;
        $phone->save();

        $found = Person::find($person->id);
        $this->assertNotNull($found->phone);
        $this->assertEquals('555-1234', $found->phone->number);
    }

    /**
     * testPostHasManyComments
     */
    public function testPostHasManyComments()
    {
        $post = Post::create(['name' => 'Comments Post']);

        $this->createComment('Comment 1', 'First', $post->id, true);
        $this->createComment('Comment 2', 'Second', $post->id, true);

        $found = Post::find($post->id);
        $this->assertCount(2, $found->comments);
    }

    /**
     * testPostCommentsScopeFilter
     */
    public function testPostCommentsScopeFilter()
    {
        $post = Post::create(['name' => 'Scoped Post']);

        $this->createComment('Visible', 'Yes', $post->id, true);
        $this->createComment('Hidden', 'No', $post->id, false);

        $found = Post::find($post->id);
        $this->assertCount(1, $found->comments);
    }

    /**
     * testPostBelongsToManyTags
     */
    public function testPostBelongsToManyTags()
    {
        $post = Post::create(['name' => 'Tagged Post']);
        $tag1 = Tag::create(['name' => 'PHP']);
        $tag2 = Tag::create(['name' => 'Laravel']);

        $post->tags()->attach([$tag1->id, $tag2->id]);

        $found = Post::find($post->id);
        $this->assertCount(2, $found->tags);
    }

    /**
     * testCommentBelongsToPost
     */
    public function testCommentBelongsToPost()
    {
        $post = Post::create(['name' => 'Parent Post']);

        $comment = $this->createComment('Child Comment', 'Content', $post->id);

        $found = Comment::find($comment->id);
        $this->assertNotNull($found->post);
        $this->assertEquals('Parent Post', $found->post->name);
    }

    /**
     * testUserBelongsToManyRoles
     */
    public function testUserBelongsToManyRoles()
    {
        $user = User::make(['username' => 'testuser']);
        $user->forceSave();

        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Editor']);

        $user->roles()->attach([$role1->id, $role2->id]);

        $found = User::find($user->id);
        $this->assertCount(2, $found->roles);
    }

    /**
     * testUserBelongsToManyRolesWithPivotData
     */
    public function testUserBelongsToManyRolesWithPivotData()
    {
        $user = User::make(['username' => 'pivotuser']);
        $user->forceSave();

        $role = Role::create(['name' => 'Manager']);

        $user->roles_pivot()->attach($role->id, [
            'clearance_level' => 'high',
            'is_executive' => true,
        ]);

        $found = User::find($user->id);
        $pivot = $found->roles_pivot->first()->pivot;
        $this->assertEquals('high', $pivot->clearance_level);
        $this->assertEquals(1, $pivot->is_executive);
    }

    /**
     * testCountryHasManyCities
     */
    public function testCountryHasManyCities()
    {
        $country = Country::create(['name' => 'Test Country', 'code' => 'TC']);
        City::create(['name' => 'City A', 'custom_country_id' => $country->id]);
        City::create(['name' => 'City B', 'custom_country_id' => $country->id]);

        $found = Country::find($country->id);
        $this->assertCount(2, $found->cities);
    }

    /**
     * testReviewMorphToPlugin
     */
    public function testReviewMorphToPlugin()
    {
        $plugin = new Plugin;
        $plugin->name = 'Test Plugin';
        $plugin->code = 'test-plugin';
        $plugin->content = 'Plugin content';
        $plugin->save();

        $review = new Review;
        $review->feature_color = '#ff0000';
        $review->product_type = Plugin::class;
        $review->product_id = $plugin->id;
        $review->save();

        $found = Review::find($review->id);
        $this->assertNotNull($found->product);
        $this->assertInstanceOf(Plugin::class, $found->product);
    }

    /**
     * testReviewMorphToTheme
     */
    public function testReviewMorphToTheme()
    {
        $theme = Theme::create(['name' => 'Test Theme', 'code' => 'test']);
        $review = new Review;
        $review->feature_color = '#00ff00';
        $review->product_type = Theme::class;
        $review->product_id = $theme->id;
        $review->save();

        $found = Review::find($review->id);
        $this->assertNotNull($found->product);
        $this->assertInstanceOf(Theme::class, $found->product);
    }

    /**
     * testPostMorphToManyGalleries
     */
    public function testPostMorphToManyGalleries()
    {
        $post = Post::create(['name' => 'Gallery Post']);

        $gallery = new Gallery;
        $gallery->title = 'GALLERY ONE';
        $gallery->subtitle = 'subtitle';
        $gallery->start_date = '2026-01-01';
        $gallery->forceSave();

        $post->galleries()->add($gallery);

        $found = Post::find($post->id);
        $this->assertCount(1, $found->galleries);
        $this->assertEquals('GALLERY ONE', $found->galleries->first()->title);
    }

    /**
     * createComment helper
     */
    protected function createComment(string $name, string $content, ?int $postId = null, ?bool $isVisible = null): Comment
    {
        $comment = new Comment;
        $comment->name = $name;
        $comment->content = $content;

        if ($postId !== null) {
            $comment->post_id = $postId;
        }

        if ($isVisible !== null) {
            $comment->is_visible = $isVisible;
        }

        $comment->save();

        return $comment;
    }
}
