<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\User;
use October\Test\Models\Country;
use October\Test\Models\Tag;
use October\Test\Models\Phone;
use October\Test\Models\Review;
use October\Test\Models\Channel;
use October\Test\Models\Member;
use October\Test\Models\Category;
use October\Test\Models\Gallery;
use October\Test\Models\Product;
use October\Test\Models\Role;
use October\Test\Models\Location;
use October\Test\Models\Page;

/**
 * ModelDefinitionTest validates model relationship and property definitions
 */
class ModelDefinitionTest extends PluginTestCase
{
    /**
     * @dataProvider modelTableProvider
     */
    public function testModelHasTableDefined(string $modelClass, string $expectedTable)
    {
        $model = new $modelClass;
        $this->assertEquals($expectedTable, $model->getTable());
    }

    /**
     * modelTableProvider
     */
    public static function modelTableProvider(): array
    {
        return [
            'Person' => [Person::class, 'october_test_people'],
            'Post' => [Post::class, 'october_test_posts'],
            'Comment' => [Comment::class, 'october_test_comments'],
            'User' => [User::class, 'october_test_users'],
            'Country' => [Country::class, 'october_test_countries'],
            'Tag' => [Tag::class, 'october_test_tags'],
            'Phone' => [Phone::class, 'october_test_phones'],
            'Review' => [Review::class, 'october_test_reviews'],
            'Channel' => [Channel::class, 'october_test_channels'],
            'Member' => [Member::class, 'october_test_members'],
            'Category' => [Category::class, 'october_test_categories'],
            'Gallery' => [Gallery::class, 'october_test_galleries'],
            'Product' => [Product::class, 'october_test_products'],
            'Role' => [Role::class, 'october_test_roles'],
            'Location' => [Location::class, 'october_test_locations'],
            'Page' => [Page::class, 'october_test_pages'],
        ];
    }

    /**
     * testPersonRelations
     */
    public function testPersonRelations()
    {
        $model = new Person;
        $this->assertArrayHasKey('phone', $model->hasOne);
        $this->assertArrayHasKey('alt_phone', $model->hasOne);
    }

    /**
     * testPostRelations
     */
    public function testPostRelations()
    {
        $model = new Post;
        $this->assertArrayHasKey('comments', $model->hasMany);
        $this->assertArrayHasKey('tags', $model->belongsToMany);
        $this->assertArrayHasKey('review', $model->morphOne);
        $this->assertArrayHasKey('galleries', $model->morphToMany);
        $this->assertArrayHasKey('status', $model->belongsTo);
        $this->assertArrayHasKey('user', $model->belongsTo);
    }

    /**
     * testCommentRelations
     */
    public function testCommentRelations()
    {
        $model = new Comment;
        $this->assertArrayHasKey('post', $model->belongsTo);
        $this->assertArrayHasKey('user', $model->belongsTo);
        $this->assertArrayHasKey('photo', $model->attachOne);
        $this->assertArrayHasKey('child_comments', $model->hasMany);
    }

    /**
     * testUserRelations
     */
    public function testUserRelations()
    {
        $model = new User;
        $this->assertArrayHasKey('country', $model->belongsTo);
        $this->assertArrayHasKey('posts', $model->hasMany);
        $this->assertArrayHasKey('roles', $model->belongsToMany);
        $this->assertArrayHasKey('roles_pivot', $model->belongsToMany);
        $this->assertArrayHasKey('roles_pivot_model', $model->belongsToMany);
        $this->assertArrayHasKey('photo', $model->attachOne);
        $this->assertArrayHasKey('portfolio', $model->attachMany);
    }

    /**
     * testCountryRelations
     */
    public function testCountryRelations()
    {
        $model = new Country;
        $this->assertArrayHasKey('cities', $model->hasMany);
        $this->assertArrayHasKey('types', $model->belongsToMany);
        $this->assertArrayHasKey('posts', $model->hasManyThrough);
    }

    /**
     * testReviewRelations
     */
    public function testReviewRelations()
    {
        $model = new Review;
        $this->assertArrayHasKey('product', $model->morphTo);
        $this->assertArrayHasKey('photo', $model->attachOne);
    }

    /**
     * testProductRelations
     */
    public function testProductRelations()
    {
        $model = new Product;
        $this->assertArrayHasKey('location_built', $model->belongsTo);
        $this->assertArrayHasKey('company', $model->belongsTo);
        $this->assertArrayHasKey('location_sold', $model->belongsToMany);
        $this->assertArrayHasKey('categories', $model->belongsToMany);
        $this->assertArrayHasKey('offers', $model->hasMany);
        $this->assertArrayHasKey('certificate', $model->attachOne);
        $this->assertArrayHasKey('gallery', $model->attachMany);
    }

    /**
     * testChannelRelations
     */
    public function testChannelRelations()
    {
        $model = new Channel;
        $this->assertArrayHasKey('user', $model->belongsTo);
        $this->assertArrayHasKey('related', $model->belongsToMany);
    }

    /**
     * testModelsWithValidationHaveRules
     */
    public function testModelsWithValidationHaveRules()
    {
        $modelsWithRules = [
            Person::class => ['name'],
            Post::class => ['name'],
            Comment::class => ['name'],
            User::class => ['username'],
            Country::class => ['name'],
            Tag::class => ['name'],
            Review::class => ['feature_color'],
        ];

        foreach ($modelsWithRules as $modelClass => $expectedRuleKeys) {
            $model = new $modelClass;
            foreach ($expectedRuleKeys as $ruleKey) {
                $this->assertArrayHasKey(
                    $ruleKey,
                    $model->rules,
                    class_basename($modelClass) . " should have a rule for '{$ruleKey}'"
                );
            }
        }
    }

    /**
     * testJsonableAttributes
     */
    public function testJsonableAttributes()
    {
        $person = new Person;
        $this->assertContains('hobbies', $person->getJsonable());
        $this->assertContains('sports', $person->getJsonable());

        $post = new Post;
        $this->assertContains('tags_array', $post->getJsonable());

        $comment = new Comment;
        $this->assertContains('breakdown', $comment->getJsonable());
        $this->assertContains('mood', $comment->getJsonable());

        $country = new Country;
        $this->assertContains('states', $country->getJsonable());
        $this->assertContains('pages', $country->getJsonable());
    }
}
