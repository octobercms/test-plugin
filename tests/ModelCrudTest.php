<?php namespace October\Test\Tests;

use Site;
use PluginTestCase;
use Backend\Widgets\Form;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\Tag;
use October\Test\Models\Country;
use October\Test\Models\Member;
use October\Test\Models\Category;
use October\Test\Models\Channel;
use October\Test\Controllers\People;
use Backend\Models\User as BackendUser;

/**
 * ModelCrudTest checks records of the key models are created, read back, updated and deleted.
 */
class ModelCrudTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testCreatePerson checks a person created with mass assignment reads back its name and preferred name.
     */
    public function testCreatePerson()
    {
        $person = Person::create(['name' => 'Test Person', 'preferred_name' => 'Tester']);

        $this->assertNotNull($person->id);
        $this->assertEquals('Test Person', $person->name);

        $found = Person::find($person->id);
        $this->assertEquals('Test Person', $found->name);
        $this->assertEquals('Tester', $found->preferred_name);
    }

    /**
     * testPersonPreferredNameDefault checks the Joey default from the model $attributes is saved when no preferred name is supplied.
     */
    public function testPersonPreferredNameDefault()
    {
        $person = Person::create(['name' => 'Default Person']);

        $this->assertEquals('Joey', Person::find($person->id)->preferred_name);
    }

    /**
     * testUpdatePerson checks a changed name is saved over the original.
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
     * testDeletePerson checks a deleted person can no longer be found.
     */
    public function testDeletePerson()
    {
        $person = Person::create(['name' => 'Delete Me']);
        $id = $person->id;

        $person->delete();

        $this->assertNull(Person::find($id));
    }

    /**
     * testPersonApiKeyIsSavedButNotMassAssigned checks the api_key attribute is ignored by mass assignment and saved when set directly.
     */
    public function testPersonApiKeyIsSavedButNotMassAssigned()
    {
        $person = Person::make(['name' => 'Keyed Person', 'api_key' => 'mass-assigned']);
        $this->assertNull($person->api_key);

        $person->api_key = 'secret-key';
        $person->save();

        $this->assertEquals('secret-key', Person::find($person->id)->api_key);
    }

    /**
     * testPersonFormOnlyPasswordIsNotSaved checks the underscore prefixed _password field is posted by the person form but purged before saving.
     */
    public function testPersonFormOnlyPasswordIsNotSaved()
    {
        request()->setMethod('POST');
        request()->request->replace(['Person' => ['name' => 'Form Person', '_password' => 'secret']]);

        $form = $this->makePersonForm();
        $this->assertEquals('secret', $form->getSaveData()['_password']);

        $form->setFormValues();
        $person = $form->getModel();
        $person->save();

        $found = Person::find($person->id);
        $this->assertEquals('Form Person', $found->name);
        $this->assertArrayNotHasKey('_password', $found->getAttributes());
    }

    /**
     * testCreatePost checks a post created with mass assignment generates a slug.
     */
    public function testCreatePost()
    {
        $post = Post::create(['name' => 'Test Post', 'content_html' => '<p>Content</p>']);

        $this->assertNotNull($post->id);
        $this->assertEquals('Test Post', $post->name);
        $this->assertNotEmpty($post->slug, 'Slug should be auto-generated');
    }

    /**
     * testPostSlugGeneration checks the Sluggable trait builds the slug from the name.
     */
    public function testPostSlugGeneration()
    {
        $post = Post::create(['name' => 'My Test Post Title']);

        $this->assertEquals('my-test-post-title', $post->slug);
    }

    /**
     * testCreateComment checks a comment with attributes set one by one is saved and found again.
     */
    public function testCreateComment()
    {
        $comment = new Comment;
        $comment->name = 'Test Comment';
        $comment->content = 'Comment body';
        $comment->save();

        $found = Comment::find($comment->id);
        $this->assertEquals('Test Comment', $found->name);
        $this->assertEquals('Comment body', $found->content);
    }

    /**
     * testCommentSoftDelete checks a deleted comment is hidden from queries but kept in the table.
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
     * testCreateTag checks a tag created with mass assignment reads back its name.
     */
    public function testCreateTag()
    {
        $tag = Tag::create(['name' => 'Laravel']);

        $this->assertNotNull($tag->id);
        $this->assertEquals('Laravel', $tag->name);
    }

    /**
     * testTagFullNameAccessor checks the full_name accessor appends the fixed surname to the name.
     */
    public function testTagFullNameAccessor()
    {
        $tag = Tag::create(['name' => 'October']);

        $this->assertEquals('October Grossbard', $tag->full_name);
    }

    /**
     * testCreateCountry checks a country created with mass assignment reads back its name.
     */
    public function testCreateCountry()
    {
        $country = Country::create(['name' => 'Australia', 'code' => 'AU']);

        $this->assertNotNull($country->id);
        $this->assertEquals('Australia', $country->name);
    }

    /**
     * testCountryCustomAccessor checks the country_name_custom accessor, used as the nameFrom of the location country field, wraps the name in brackets.
     */
    public function testCountryCustomAccessor()
    {
        $country = Country::create(['name' => 'Canada', 'code' => 'CA']);

        $this->assertEquals('[Canada]', $country->country_name_custom);
    }

    /**
     * testCreateMember checks a new member is saved on the current site and becomes its own site root.
     */
    public function testCreateMember()
    {
        $member = new Member;
        $member->name = 'Created Member';
        $member->save();

        $found = Member::find($member->id);
        $this->assertEquals('Created Member', $found->name);
        $this->assertEquals(Site::getSiteIdFromContext(), $found->site_id);
        $this->assertEquals($member->id, $found->site_root_id);
    }

    /**
     * testCreateCategory checks a new category reads back its name and code and is saved on the current site.
     */
    public function testCreateCategory()
    {
        $category = new Category;
        $category->name = 'Created Category';
        $category->code = 'created-category';
        $category->save();

        $found = Category::find($category->id);
        $this->assertEquals('Created Category', $found->name);
        $this->assertEquals('created-category', $found->code);
        $this->assertEquals(Site::getSiteIdFromContext(), $found->site_id);
    }

    /**
     * testCreateChannel checks a new channel reads back its jsonable services and title accessor and is placed as a root node.
     */
    public function testCreateChannel()
    {
        $channel = new Channel;
        $channel->title = 'Created Channel';
        $channel->services = ['streaming', 'archive'];
        $channel->save();

        $found = Channel::find($channel->id);
        $this->assertEquals(['streaming', 'archive'], $found->services);
        $this->assertEquals("Created Channel (#{$channel->id})", $found->custom_title);
        $this->assertEquals($found->nest_left + 1, $found->nest_right);
        $this->assertEquals(0, $found->nest_depth);
    }

    /**
     * testPersonNullableAttribute checks the Nullable trait saves an empty is_married value as null.
     */
    public function testPersonNullableAttribute()
    {
        $person = Person::create(['name' => 'Nullable Test', 'is_married' => '']);

        $found = Person::find($person->id);
        $this->assertNull($found->is_married);
    }

    /**
     * testPersonJsonableAttributes checks the jsonable hobbies and sports arrays are saved and read back.
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
     * testPersonAfterCreateSetsAltId checks afterCreate sets the fixture alt_id that the alt_phone relation matches on.
     */
    public function testPersonAfterCreateSetsAltId()
    {
        $person = Person::create(['name' => 'Alt ID Test']);

        $this->assertEquals($person->id + 100, $person->alt_id);
        $this->assertEquals($person->id + 100, Person::find($person->id)->alt_id);
    }

    /**
     * makePersonForm builds the person form widget, signing in a backend user since form widgets load user preferences.
     */
    protected function makePersonForm(): Form
    {
        $superUser = new BackendUser;
        $superUser->login = 'tester';
        $superUser->is_superuser = true;
        $this->actingAs($superUser);

        $controller = new People;
        $config = $controller->makeConfig('$/october/test/models/person/fields.yaml');
        $config->model = new Person;
        $config->arrayName = 'Person';
        $config->context = 'create';

        $form = $controller->makeWidget(Form::class, $config);
        $form->bindToController();

        return $form;
    }
}
