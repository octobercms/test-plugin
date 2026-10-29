<?php namespace October\Test\Tests;

use PluginTestCase;
use System\Models\File;
use System\Models\TranslatableFile;
use Illuminate\Support\MessageBag;
use October\Rain\Database\Model;
use October\Rain\Database\ModelException;
use October\Test\Models\Meta;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\Tag;
use October\Test\Models\Country;
use October\Test\Models\Review;
use October\Test\Models\Gallery;
use October\Test\Models\User;
use October\Test\Models\Role;
use October\Test\Models\Plugin;
use October\Test\Models\Product;
use October\Test\Models\Location;
use October\Test\Controllers\Plugins;
use Backend\Models\User as BackendUser;

/**
 * ModelValidationTest checks the model validation rules reject invalid records and accept valid ones.
 */
class ModelValidationTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testPersonRequiresName checks a person without a name fails validation.
     */
    public function testPersonRequiresName()
    {
        $this->expectException(ModelException::class);

        Person::create(['name' => '']);
    }

    /**
     * testPersonPassesValidation checks a person with a name is saved.
     */
    public function testPersonPassesValidation()
    {
        $person = Person::create(['name' => 'Valid Person']);

        $this->assertNotNull($person->id);
    }

    /**
     * testPersonEmailMustBeValid checks the nullable email rule rejects a malformed address and accepts an empty or valid one.
     */
    public function testPersonEmailMustBeValid()
    {
        $person = new Person;
        $person->name = 'Email Person';
        $person->email = 'not-an-email';

        $this->assertValidationFails($person, 'email');

        $person->email = null;
        $this->assertTrue($person->validate());

        $person->email = 'person@example.com';
        $this->assertTrue($person->validate());
    }

    /**
     * testPostRequiresName checks a post without a name fails validation.
     */
    public function testPostRequiresName()
    {
        $this->expectException(ModelException::class);

        Post::create(['name' => '']);
    }

    /**
     * testPostPassesValidation checks a post with a name is saved.
     */
    public function testPostPassesValidation()
    {
        $post = Post::create(['name' => 'Valid Post']);

        $this->assertNotNull($post->id);
    }

    /**
     * testCommentRequiresName checks a comment without a name fails validation.
     */
    public function testCommentRequiresName()
    {
        $this->expectException(ModelException::class);

        Comment::create(['name' => '', 'content' => 'No name']);
    }

    /**
     * testCommentPassesValidation checks a comment with a name is saved.
     */
    public function testCommentPassesValidation()
    {
        $comment = Comment::create(['name' => 'Valid Comment', 'content' => 'Some content']);

        $this->assertNotNull($comment->id);
    }

    /**
     * testTagRequiresName checks a tag without a name fails validation.
     */
    public function testTagRequiresName()
    {
        $this->expectException(ModelException::class);

        Tag::create(['name' => '']);
    }

    /**
     * testCountryRequiresName checks a country without a name fails validation.
     */
    public function testCountryRequiresName()
    {
        $this->expectException(ModelException::class);

        Country::create(['name' => '', 'code' => 'XX']);
    }

    /**
     * testReviewRequiresFeatureColor checks a review without a feature color fails validation.
     */
    public function testReviewRequiresFeatureColor()
    {
        $this->expectException(ModelException::class);

        Review::create(['feature_color' => '']);
    }

    /**
     * testReviewPassesValidation checks a review with a feature color is saved.
     */
    public function testReviewPassesValidation()
    {
        $review = Review::create(['feature_color' => '#ff0000']);

        $this->assertNotNull($review->id);
    }

    /**
     * testUserRequiresUsernamePhotoPortfolioAndRoles checks the user rules require the username and the photo, portfolio and roles relations, using the custom messages.
     */
    public function testUserRequiresUsernamePhotoPortfolioAndRoles()
    {
        $errors = $this->assertValidationFails(new User, 'username');

        $this->assertEquals('The username field is WOW required.', $errors->first('username'));
        $this->assertEquals('The photo field is required PHOTO.', $errors->first('photo'));
        $this->assertEquals('The portfolio field is WOW required.', $errors->first('portfolio'));
        $this->assertEquals('The roles field is WOW required.', $errors->first('roles'));
    }

    /**
     * testUserPassesValidationWithDeferredRelations checks a new user saves once its required relations are bound with a session key.
     */
    public function testUserPassesValidationWithDeferredRelations()
    {
        $sessionKey = uniqid('session', true);

        $user = new User;
        $user->username = 'complete';
        $user->photo()->add($this->makeFile(File::class, 'photo.jpg'), $sessionKey);
        $user->portfolio()->add($this->makeFile(TranslatableFile::class, 'work.jpg'), $sessionKey);
        $user->roles()->add(Role::create(['name' => 'Validated Role']), $sessionKey);
        $user->save(null, $sessionKey);

        $found = User::find($user->id);
        $this->assertEquals('photo.jpg', $found->photo->file_name);
        $this->assertEquals(['work.jpg'], $found->portfolio->pluck('file_name')->all());
        $this->assertEquals(['Validated Role'], $found->roles->pluck('name')->all());
    }

    /**
     * testProductLocationSoldRuleCountsRelatedRecords checks the between rule on the location_sold relation allows two locations but not three.
     */
    public function testProductLocationSoldRuleCountsRelatedRecords()
    {
        $product = new Product;
        $product->title = 'Widely Sold Widget';
        $product->save();

        $product->location_sold()->attach([$this->makeLocation('One')->id, $this->makeLocation('Two')->id]);
        $this->assertTrue(Product::find($product->id)->validate());

        $product->location_sold()->attach($this->makeLocation('Three')->id);
        $this->assertValidationFails(Product::find($product->id), 'location_sold');
    }

    /**
     * testGalleryUsesRegisteredRules checks the uppercase and betwixt rules registered by the plugin run as Gallery model rules.
     */
    public function testGalleryUsesRegisteredRules()
    {
        $gallery = new Gallery(['title' => 'lowercase title']);
        $gallery->subtitle = 'ab';
        $gallery->start_date = now();

        $errors = $this->assertValidationFails($gallery, 'title');

        $this->assertEquals('The title must be uppercase (strict mode).', $errors->first('title'));
        $this->assertEquals('The subtitle must be between 3 and 255.', $errors->first('subtitle'));
    }

    /**
     * testGalleryRuleObjectRequiresLowercaseSubtitle checks the local rule object that Gallery adds in beforeValidate.
     */
    public function testGalleryRuleObjectRequiresLowercaseSubtitle()
    {
        $gallery = new Gallery(['title' => 'SUMMER']);
        $gallery->subtitle = 'Beach Days';
        $gallery->start_date = now();

        try {
            $gallery->validate();
            $this->fail('An uppercase subtitle should fail validation');
        }
        catch (ModelException $ex) {
            $this->assertEquals('The subtitle must be lowercase.', $ex->getErrors()->first('subtitle'));
        }

        $gallery->subtitle = 'beach days';
        $this->assertTrue($gallery->validate());
    }

    /**
     * testPluginIsNotCreatedWhenMetaFailsValidation checks the Plugins form leaves no plugin behind when its meta fields fail validation.
     */
    public function testPluginIsNotCreatedWhenMetaFailsValidation()
    {
        $errors = $this->submitPluginForm([
            'name' => 'Metaless Plugin',
            'code' => 'metaless-plugin',
            'content' => 'Missing its meta title',
            'meta' => ['meta_description' => 'A description', 'meta_keywords' => 'meta'],
        ]);

        $this->assertTrue($errors->has('meta.meta_title'));
        $this->assertFalse(Plugin::where('code', 'metaless-plugin')->exists());
        $this->assertFalse(Meta::where('meta_description', 'A description')->exists());
    }

    /**
     * testMetaIsRolledBackWhenPluginFailsValidation checks the Plugins form removes the already saved meta when the plugin itself fails validation.
     */
    public function testMetaIsRolledBackWhenPluginFailsValidation()
    {
        $errors = $this->submitPluginForm([
            'name' => 'Codeless Plugin',
            'content' => 'Missing its code',
            'meta' => ['meta_title' => 'Orphan title', 'meta_description' => 'Orphan description', 'meta_keywords' => 'meta'],
        ]);

        $this->assertTrue($errors->has('code'));
        $this->assertFalse(Meta::where('meta_title', 'Orphan title')->exists());
    }

    /**
     * assertValidationFails validates the model, asserts the attribute has an error and returns every error.
     */
    protected function assertValidationFails(Model $model, string $attribute): MessageBag
    {
        try {
            $model->validate();
        }
        catch (ModelException $ex) {
            $this->assertTrue($ex->getErrors()->has($attribute), "Expected a validation error for [{$attribute}]");

            return $ex->getErrors();
        }

        $this->fail("Expected validation to fail for [{$attribute}]");
    }

    /**
     * submitPluginForm posts the data to the Plugins create form, which saves the meta fields to the related model, and returns the validation errors.
     */
    protected function submitPluginForm(array $data): MessageBag
    {
        $superUser = new BackendUser;
        $superUser->login = 'tester';
        $superUser->is_superuser = true;
        $this->actingAs($superUser);

        request()->setMethod('POST');
        request()->request->replace(['Plugin' => $data]);

        try {
            (new Plugins)->create_onSave();
        }
        catch (ModelException $ex) {
            return $ex->getErrors();
        }

        $this->fail('Expected the Plugins form to fail validation');
    }

    /**
     * makeFile saves a file record that points to no file on disk.
     */
    protected function makeFile(string $class, string $fileName): File
    {
        $file = new $class;
        $file->disk_name = uniqid() . '.jpg';
        $file->file_name = $fileName;
        $file->file_size = 1;
        $file->content_type = 'image/jpeg';
        $file->save();

        return $file;
    }

    /**
     * makeLocation saves a location with a name.
     */
    protected function makeLocation(string $name): Location
    {
        $location = new Location;
        $location->name = $name;
        $location->save();

        return $location;
    }
}
