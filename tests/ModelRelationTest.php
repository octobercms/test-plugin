<?php namespace October\Test\Tests;

use Db;
use PluginTestCase;
use System\Models\File;
use System\Models\TranslatableFile;
use October\Test\Models\Meta;
use October\Test\Models\Company;
use October\Test\Models\Attribute;
use October\Test\Models\Person;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Models\Tag;
use October\Test\Models\User;
use October\Test\Models\Role;
use October\Test\Models\UserRolePivot;
use October\Test\Models\Country;
use October\Test\Models\City;
use October\Test\Models\Phone;
use October\Test\Models\Review;
use October\Test\Models\Gallery;
use October\Test\Models\Plugin;
use October\Test\Models\Theme;
use October\Test\Models\Channel;
use October\Test\Models\Product;
use October\Test\Models\ProductOffer;
use October\Test\Models\ProductCategory;
use October\Test\Models\Location;
use October\Test\Models\RepeaterItem;

/**
 * ModelRelationTest checks each model relation saves its records and reads them back after a reload.
 */
class ModelRelationTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testPersonHasOnePhone checks the phone relation returns the active phone saved on the person's id.
     */
    public function testPersonHasOnePhone()
    {
        $person = Person::create(['name' => 'Phone Owner']);

        $this->makePhone('Home Phone', $person->id, '555-1234');

        $found = Person::find($person->id);
        $this->assertNotNull($found->phone);
        $this->assertEquals('555-1234', $found->phone->number);
    }

    /**
     * testPhoneScopeExcludesInactivePhone checks the isActive scope on the phone relation leaves out an inactive phone.
     */
    public function testPhoneScopeExcludesInactivePhone()
    {
        $person = Person::create(['name' => 'Inactive Phone Owner']);

        $this->makePhone('Old Phone', $person->id, '555-0000', false);
        $this->assertNull(Person::find($person->id)->phone);

        $this->makePhone('New Phone', $person->id, '555-0001');
        $this->assertEquals('New Phone', Person::find($person->id)->phone->name);
    }

    /**
     * testHasOneOtherKeyResolvesAltPhone checks the alt_phone relation matches phones on the person's alt_id instead of the id.
     */
    public function testHasOneOtherKeyResolvesAltPhone()
    {
        $person = Person::create(['name' => 'Alt Phone Owner']);
        $this->makePhone('Primary', $person->id, '555-0100');

        $phone = new Phone;
        $phone->name = 'Emergency';
        $phone->number = '555-0911';
        $phone->save();

        $person->alt_phone = $phone;
        $person->save();

        $found = Person::find($person->id);
        $this->assertEquals($person->alt_id, $phone->fresh()->person_id);
        $this->assertEquals('Emergency', $found->alt_phone->name);
        $this->assertEquals('Primary', $found->phone->name);
    }

    /**
     * testPostHasManyComments checks comments saved with the post id are returned by the comments relation.
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
     * testPostCommentsScopeFilter checks the isVisible scope on the comments relation leaves out a hidden comment.
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
     * testPostBelongsToManyTags checks tags attached through the custom pivot keys are read back.
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
     * testPostMorphOneReviewUsesProductMorphName checks the review relation stores the post in the review's product morph columns.
     */
    public function testPostMorphOneReviewUsesProductMorphName()
    {
        $post = Post::create(['name' => 'Reviewed Post']);

        $review = new Review;
        $review->feature_color = '#0000ff';
        $post->review()->add($review);

        $found = Post::find($post->id);
        $this->assertEquals('#0000ff', $found->review->feature_color);
        $this->assertEquals($post->getMorphClass(), $found->review->product_type);
        $this->assertEquals($post->id, $found->review->product_id);
        $this->assertEquals('Reviewed Post', Review::find($review->id)->product->name);
    }

    /**
     * testPostStatusOnlyMatchesStatusAttributes checks the conditions on the status relation ignore an attribute of another type in the shared table.
     */
    public function testPostStatusOnlyMatchesStatusAttributes()
    {
        $post = Post::create(['name' => 'Status Post']);

        $post->status_id = $this->makeAttribute(Attribute::GENERAL_STATUS, 'Reviewing')->id;
        $post->save();
        $this->assertEquals('Reviewing', Post::find($post->id)->status->name);

        $post->status_id = $this->makeAttribute(Attribute::GENERAL_TYPE, 'Wizard')->id;
        $post->save();
        $this->assertNull(Post::find($post->id)->status);
    }

    /**
     * testCommentChildCommentsIncludeTrashed checks the withTrashed scope on child_comments keeps a soft deleted reply.
     */
    public function testCommentChildCommentsIncludeTrashed()
    {
        $parent = $this->createComment('Thread Starter', 'First');

        $reply = new Comment;
        $reply->name = 'Deleted Reply';
        $reply->parent_comment_id = $parent->id;
        $reply->save();
        $reply->delete();

        $this->assertEquals(['Deleted Reply'], Comment::find($parent->id)->child_comments->pluck('name')->all());
    }

    /**
     * testCommentBelongsToPost checks a comment reads its parent post through the post relation.
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
     * testUserBelongsToManyRoles checks roles attached to a user are read back through the plain roles relation.
     */
    public function testUserBelongsToManyRoles()
    {
        $user = $this->makeUser('testuser');

        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Editor']);

        $user->roles()->attach([$role1->id, $role2->id]);

        $found = User::find($user->id);
        $this->assertCount(2, $found->roles);
    }

    /**
     * testUserBelongsToManyRolesWithPivotData checks the pivot columns listed on roles_pivot are saved and read back.
     */
    public function testUserBelongsToManyRolesWithPivotData()
    {
        $user = $this->makeUser('pivotuser');

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
     * testUserRolesPivotModelReadsPivotAttributes checks roles_pivot_model returns a UserRolePivot with its columns and country relation.
     */
    public function testUserRolesPivotModelReadsPivotAttributes()
    {
        $user = $this->makeUser('pivotmodeluser');
        $role = Role::create(['name' => 'Pivot Model Role']);
        $country = Country::create(['name' => 'Pivotland', 'code' => 'PV']);

        $user->roles_pivot_model()->attach($role->id, [
            'clearance_level' => 'Secret',
            'is_executive' => true,
            'country_id' => $country->id,
            'evolution' => 2,
            'salary' => 5000,
        ]);

        $pivot = User::find($user->id)->roles_pivot_model->first()->pivot;
        $this->assertInstanceOf(UserRolePivot::class, $pivot);
        $this->assertNotNull($pivot->id);
        $this->assertEquals('Secret', $pivot->clearance_level);
        $this->assertEquals(2, $pivot->evolution);
        $this->assertEquals(5000, $pivot->salary);
        $this->assertEquals('Pivotland', $pivot->country->name);
    }

    /**
     * testUserRolesPivotModelSavesThroughPivot checks saving the pivot model updates its row, with an empty evolution saved as null.
     */
    public function testUserRolesPivotModelSavesThroughPivot()
    {
        $user = $this->makeUser('pivotsaveuser');
        $role = Role::create(['name' => 'Pivot Save Role']);
        $user->roles_pivot_model()->attach($role->id, ['clearance_level' => 'Low', 'evolution' => 1]);

        $pivot = User::find($user->id)->roles_pivot_model->first()->pivot;
        $pivot->clearance_level = 'Top Secret';
        $pivot->evolution = '';
        $pivot->save();

        $pivot = User::find($user->id)->roles_pivot_model->first()->pivot;
        $this->assertEquals('Top Secret', $pivot->clearance_level);
        $this->assertNull($pivot->evolution);
    }

    /**
     * testUserPortfolioAttachesTranslatableFiles checks files added to the portfolio are read back as TranslatableFile models.
     */
    public function testUserPortfolioAttachesTranslatableFiles()
    {
        $user = $this->makeUser('portfoliouser');

        $user->portfolio()->add($this->makeFile(TranslatableFile::class, 'first.jpg'));
        $user->portfolio()->add($this->makeFile(TranslatableFile::class, 'second.jpg'));

        $portfolio = User::find($user->id)->portfolio;
        $this->assertCount(2, $portfolio);
        $this->assertContainsOnlyInstancesOf(TranslatableFile::class, $portfolio);
        $this->assertEqualsCanonicalizing(['first.jpg', 'second.jpg'], $portfolio->pluck('file_name')->all());
    }

    /**
     * testCountryHasManyCities checks cities saved on the custom_country_id key are returned by the cities relation.
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
     * testCountryHasManyPostsThroughUsers checks the posts relation returns the posts written by users from the country.
     */
    public function testCountryHasManyPostsThroughUsers()
    {
        $country = Country::create(['name' => 'Throughland', 'code' => 'TL']);
        $author = $this->makeUser('throughuser', $country);
        $this->makePost('First Through Post', $author);
        $this->makePost('Second Through Post', $author);
        $this->makePost('Foreign Post', $this->makeUser('foreignuser'));

        $found = Country::find($country->id);
        $this->assertEqualsCanonicalizing(['First Through Post', 'Second Through Post'], $found->posts->pluck('name')->all());
    }

    /**
     * testCountryHasOneThroughPost checks the post relation returns one post through the country's users, or null without one.
     */
    public function testCountryHasOneThroughPost()
    {
        $country = Country::create(['name' => 'Singleland', 'code' => 'SG']);
        $this->makePost('Only Through Post', $this->makeUser('singleuser', $country));
        $emptyCountry = Country::create(['name' => 'Emptyland', 'code' => 'EL']);

        $this->assertEquals('Only Through Post', Country::find($country->id)->post->name);
        $this->assertNull(Country::find($emptyCountry->id)->post);
    }

    /**
     * testCountrySistersStoreRepeaterItems checks the sisters relation repeater saves its items with the fields serialized into the value column.
     */
    public function testCountrySistersStoreRepeaterItems()
    {
        $country = Country::create(['name' => 'Sisterland', 'code' => 'SL']);
        $country->sisters()->add($this->makeRepeaterItem('North', 'Harbour'));
        $country->sisters()->add($this->makeRepeaterItem('South', 'Hills'));

        $sisters = Country::find($country->id)->sisters;
        $this->assertEquals(['North', 'South'], $sisters->pluck('title')->all());
        $this->assertEquals('Hills', $sisters[1]->subtitle);

        $row = Db::table('october_test_repeater_items')->where('id', $sisters[0]->id)->first();
        $this->assertEquals($country->id, $row->parent_id);
        $this->assertNotNull($row->sort_order);
        $this->assertEquals('Harbour', json_decode($row->value, true)['subtitle']);
    }

    /**
     * testCountryDeleteRemovesSisters checks the delete option on the sisters relation removes the repeater items with the country.
     */
    public function testCountryDeleteRemovesSisters()
    {
        $country = Country::create(['name' => 'Fleeting', 'code' => 'FL']);
        $country->sisters()->add($this->makeRepeaterItem('East', 'Coast'));

        $country->delete();

        $this->assertSame(0, RepeaterItem::where('parent_id', $country->id)->count());
    }

    /**
     * testReviewMorphToPlugin checks a review stored against a plugin reads it back through the product morph.
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
     * testReviewMorphToTheme checks a review stored against a theme reads it back through the product morph.
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
     * testPluginMorphOneMetaSavesWithPlugin checks a meta assigned to a new plugin is saved against it through the taggable morph.
     */
    public function testPluginMorphOneMetaSavesWithPlugin()
    {
        $meta = new Meta;
        $meta->meta_title = 'Plugin Title';
        $meta->meta_description = 'Plugin description';
        $meta->meta_keywords = 'plugin, meta';

        $plugin = new Plugin;
        $plugin->name = 'Meta Plugin';
        $plugin->code = 'meta-plugin';
        $plugin->content = 'Plugin with meta';
        $plugin->meta = $meta;
        $plugin->save();

        $found = Plugin::find($plugin->id);
        $this->assertEquals('Plugin Title', $found->meta->meta_title);
        $this->assertEquals($plugin->getMorphClass(), $found->meta->taggable_type);
    }

    /**
     * testPostMorphToManyGalleries checks a gallery that passes its registered and rule object rules is linked to a post.
     */
    public function testPostMorphToManyGalleries()
    {
        $post = Post::create(['name' => 'Gallery Post']);

        $gallery = new Gallery;
        $gallery->title = 'GALLERY ONE';
        $gallery->subtitle = 'subtitle';
        $gallery->start_date = '2026-01-01';
        $gallery->save();

        $post->galleries()->add($gallery);

        $found = Post::find($post->id);
        $this->assertCount(1, $found->galleries);
        $this->assertEquals('GALLERY ONE', $found->galleries->first()->title);
    }

    /**
     * testProductHasManyOffers checks offers added to a product are read back through the offers relation.
     */
    public function testProductHasManyOffers()
    {
        $product = $this->makeProduct('Offer Widget');
        $product->offers()->add($this->makeOffer('Single'));
        $product->offers()->add($this->makeOffer('Bulk'));

        $this->assertEqualsCanonicalizing(['Single', 'Bulk'], Product::find($product->id)->offers->pluck('name')->all());
    }

    /**
     * testProductForceDeleteRemovesOffers checks the delete option keeps offers on a soft delete and removes them on a force delete.
     */
    public function testProductForceDeleteRemovesOffers()
    {
        $product = $this->makeProduct('Deleted Offer Widget');
        $product->offers()->add($this->makeOffer('Clearance'));

        $product->delete();
        $this->assertSame(1, ProductOffer::where('product_id', $product->id)->count());

        $product->forceDelete();
        $this->assertSame(0, ProductOffer::where('product_id', $product->id)->count());
    }

    /**
     * testProductCompanyIncludesTrashedCompany checks the withTrashed scope on the company relation keeps a soft deleted company.
     */
    public function testProductCompanyIncludesTrashedCompany()
    {
        $company = new Company;
        $company->name = 'Closed Company';
        $company->save();

        $product = $this->makeProduct('Discontinued Widget');
        $product->company = $company;
        $product->save();

        $company->delete();

        $this->assertEquals('Closed Company', Product::find($product->id)->company->name);
    }

    /**
     * testProductBelongsToManyLocationSold checks locations attached through the custom pivot keys are read back.
     */
    public function testProductBelongsToManyLocationSold()
    {
        $product = $this->makeProduct('Located Widget');
        $product->location_sold()->attach([
            $this->makeLocation('First Shop')->id,
            $this->makeLocation('Second Shop')->id,
        ]);

        $found = Product::find($product->id);
        $this->assertEqualsCanonicalizing(['First Shop', 'Second Shop'], $found->location_sold->pluck('name')->all());
    }

    /**
     * testProductBelongsToManyCategories checks the categories pivot stores each category's site_root_id from the relatedKey option.
     */
    public function testProductBelongsToManyCategories()
    {
        $product = $this->makeProduct('Categorized Widget');
        $food = $this->makeProductCategory('Snacks');
        $drink = $this->makeProductCategory('Juices');

        $product->categories()->attach([$food, $drink]);

        $found = Product::find($product->id);
        $this->assertEqualsCanonicalizing(['Snacks', 'Juices'], $found->categories->pluck('name')->all());
        $this->assertEqualsCanonicalizing(
            [$food->site_root_id, $drink->site_root_id],
            Db::table('october_test_products_categories')->where('product_id', $product->id)->pluck('category_id')->all()
        );
    }

    /**
     * testChannelRelatedIsOneWaySelfReference checks the related relation links a channel to another channel in one direction only.
     */
    public function testChannelRelatedIsOneWaySelfReference()
    {
        $news = $this->makeChannel('News');
        $sport = $this->makeChannel('Sport');

        $news->related()->attach($sport->id);

        $this->assertEquals(['Sport'], Channel::find($news->id)->related->pluck('title')->all());
        $this->assertCount(0, Channel::find($sport->id)->related);
        $this->assertTrue(
            Db::table('october_test_related_channels')->where('related_id', $news->id)->where('channel_id', $sport->id)->exists()
        );
    }

    /**
     * createComment saves a comment with an optional post and visibility.
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

    /**
     * makeAttribute saves an attribute of the given type in the shared attributes table.
     */
    protected function makeAttribute(string $type, string $name): Attribute
    {
        $attribute = new Attribute;
        $attribute->type = $type;
        $attribute->name = $name;
        $attribute->save();

        return $attribute;
    }

    /**
     * makePhone saves a phone for the given person key.
     */
    protected function makePhone(string $name, int $personId, string $number, bool $isActive = true): Phone
    {
        $phone = new Phone;
        $phone->name = $name;
        $phone->number = $number;
        $phone->person_id = $personId;
        $phone->is_active = $isActive;
        $phone->save();

        return $phone;
    }

    /**
     * makeUser saves a user without the relations its rules require, optionally from a country.
     */
    protected function makeUser(string $username, ?Country $country = null): User
    {
        $user = new User;
        $user->username = $username;

        if ($country) {
            $user->country = $country;
        }

        $user->forceSave();

        return $user;
    }

    /**
     * makePost saves a post written by the user.
     */
    protected function makePost(string $name, User $user): Post
    {
        $post = new Post;
        $post->name = $name;
        $post->user = $user;
        $post->save();

        return $post;
    }

    /**
     * makeFile returns an unsaved file record that points to no file on disk.
     */
    protected function makeFile(string $class, string $fileName): File
    {
        $file = new $class;
        $file->disk_name = uniqid() . '.jpg';
        $file->file_name = $fileName;
        $file->file_size = 1;
        $file->content_type = 'image/jpeg';

        return $file;
    }

    /**
     * makeRepeaterItem returns an unsaved repeater item with fields that have no column of their own.
     */
    protected function makeRepeaterItem(string $title, string $subtitle): RepeaterItem
    {
        $item = new RepeaterItem;
        $item->title = $title;
        $item->subtitle = $subtitle;
        $item->is_enabled = true;

        return $item;
    }

    /**
     * makeProduct saves a product with a title.
     */
    protected function makeProduct(string $title): Product
    {
        $product = new Product;
        $product->title = $title;
        $product->save();

        return $product;
    }

    /**
     * makeOffer returns an unsaved product offer.
     */
    protected function makeOffer(string $name): ProductOffer
    {
        $offer = new ProductOffer;
        $offer->name = $name;

        return $offer;
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

    /**
     * makeProductCategory saves a product category with a name.
     */
    protected function makeProductCategory(string $name): ProductCategory
    {
        $category = new ProductCategory;
        $category->name = $name;
        $category->save();

        return $category;
    }

    /**
     * makeChannel saves a root channel with a title.
     */
    protected function makeChannel(string $title): Channel
    {
        $channel = new Channel;
        $channel->title = $title;
        $channel->save();

        return $channel;
    }
}
