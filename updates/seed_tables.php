<?php namespace October\Test\Updates;

use Str;
use October\Rain\Database\Updates\Seeder;
use October\Test\Models\Attribute;
use October\Test\Models\Category;
use October\Test\Models\Channel;
use October\Test\Models\City;
use October\Test\Models\Country;
use October\Test\Models\Gallery;
use October\Test\Models\Location;
use October\Test\Models\Member;
use October\Test\Models\Layout;
use October\Test\Models\Page;
use October\Test\Models\Person;
use October\Test\Models\Phone;
use October\Test\Models\Plugin;
use October\Test\Models\Post;
use October\Test\Models\Review;
use October\Test\Models\Role;
use October\Test\Models\Theme;
use October\Test\Models\User;
use October\Test\Models\Product;
use October\Test\Models\ProductCategory;
use October\Test\Models\Company;

class SeedAllTables extends Seeder
{
    public function run()
    {
        /*
         * Test 1: People
         */
        $person = Person::create(['name' => 'Eddie Valiant', 'bio' => 'I have a phone set up already', 'expenses' => 19999, 'favcolor' => '#5fb6f5']);
        $person->phone = Phone::create(['name' => 'Mobile', 'number' => '(360) 733-2263']);
        $person->alt_phone = Phone::create(['name' => 'Home', 'number' => '(360) 867-3563']);
        $person->save();

        Person::create(['name' => 'Baby Herman', 'bio' => 'I have nothing at all', 'expenses' => 550, 'favcolor' => '#990000']);
        Phone::create(['name' => 'Work', 'number' => '(360) 595-2146']);
        Phone::create(['name' => 'Fax', 'number' => '(360) 595-2146']);
        Phone::create(['name' => 'Inactive', 'number' => '(xxx) xxx-xxx', 'is_active' => false]);

        Person::create(['name' => 'Jon Doe', 'bio' => 'I like turtles', 'favcolor' => '#111111']);
        Person::create(['name' => 'John Smith', 'bio' => 'I like dolphins', 'favcolor' => '#222222']);
        Person::create(['name' => 'Jon Smith', 'bio' => 'I like snakes', 'favcolor' => '#333333']);
        Person::create(['name' => 'Mary Smith', 'bio' => 'I like fish', 'expenses' => 2000, 'favcolor' => '#444444']);
        Person::create(['name' => 'Marvin Acme', 'bio' => 'Head of the Acme Corporation and owner of Toontown']);
        Person::create(['name' => 'Roger Rabbit', 'bio' => 'Animated anthropomorphic rabbit']);
        Person::create(['name' => 'Jessica Rabbit', 'bio' => 'One of the best-known rabbits in animation']);
        Person::create(['name' => 'Judge Doom', 'bio' => 'Also known as Baron von Rotten']);
        Person::create(['name' => 'Bandolette', 'bio' => 'Unrivaled ambush predator of the jungle.']);
        Person::create(['name' => 'Gut Bomb', 'bio' => 'A good burger gone bad...']);
        Person::create(['name' => 'Big Chuggus', 'bio' => 'SMALL CHUGGUSES NEED NOT APPLY.']);
        Person::create(['name' => 'Blaze', 'bio' => 'Fill the world with flames.']);
        Person::create(['name' => 'Tess', 'bio' => 'Your best friend or your worst enemy.']);
        Person::create(['name' => 'Bunker Jonesy', 'bio' => "Debunk'd"]);
        Person::create(['name' => 'Burnout', 'bio' => 'All roads lead to victory.']);
        Person::create(['name' => 'Bushranger', 'bio' => "He's one scrappy little tree."]);
        Person::create(['name' => 'Cole', 'bio' => "It's a dirty job but somebody's gotta do it."]);
        Person::create(['name' => 'Deadfire', 'bio' => "This town ain't big enough..."]);
        Person::create(['name' => 'Dummy', 'bio' => 'Look out!']);
        Person::create(['name' => 'Farmer Steel', 'bio' => "They trampled his corn. Now they're gonna pay."]);
        Person::create(['name' => 'Kyle', 'bio' => 'Friend of the trees. Most of them, anyway.']);
        Person::create(['name' => 'Snow Sniper', 'bio' => 'Cool and calculated.']);
        Person::create(['name' => 'Ragnarok', 'bio' => 'The cold harbinger of fate.']);
        Person::create(['name' => 'Remedy', 'bio' => 'Take your medicine.']);
        Person::create(['name' => 'Sparkplug', 'bio' => 'TBD']);
        Person::create(['name' => 'Splode', 'bio' => 'Countdown to a big boom!']);
        Person::create(['name' => 'The Reaper', 'bio' => 'Vengence for hire.']);
        Person::create(['name' => 'Crustina', 'bio' => 'Saucy, spicy, right behind you.']);
        Person::create(['name' => 'Triggerfish', 'bio' => "Stick it to 'em."]);
        Person::create(['name' => 'Turk', 'bio' => 'Hook your prey.']);
        Person::create(['name' => 'Cluck', 'bio' => "Cheep cheep cheep, cheep cheep b'kaw."]);
        Person::create(['name' => 'Rebirth Raven', 'bio' => 'Daughter of a demon and founding member of the Teen Titans.']);
        Person::create(['name' => 'Tarana', 'bio' => 'A speaker for the old world.']);
        Person::create(['name' => 'Raz', 'bio' => 'After a lifetime of training, he is finally ready to tackle its darkest mysteries.']);
        Person::create(['name' => 'Lara Croft', 'bio' => 'The extraordinary is in what we do, not who we are.']);
        Person::create(['name' => 'Shade', 'bio' => 'Stay cool.']);
        Person::create(['name' => 'Jules', 'bio' => 'Engineering perfection with a mysterious twist.']);
        Person::create(['name' => 'Rex', 'bio' => 'Hunting the competition to extinction.']);
        Person::create(['name' => 'Cabbie', 'bio' => 'First to the fare. First to the finishline.']);
        Person::create(['name' => 'Wreck Raider', 'bio' => 'Wreck to Riches.']);
        Person::create(['name' => 'Sun Tan Specialist', 'bio' => "Don't get burned."]);
        Person::create(['name' => 'Castaway Jonesy', 'bio' => "He's not lost, okay?"]);
        Person::create(['name' => 'Slurp Jonesy', 'bio' => 'Slurp up and ship out.']);
        Person::create(['name' => 'Grill Sergeant', 'bio' => 'Make it sizzle.']);
        Person::create(['name' => 'Jonesy The First', 'bio' => 'Never forget your first run.']);
        Person::create(['name' => 'Sash Sergeant', 'bio' => 'Set up camp and start a firefight.']);
        Person::create(['name' => 'Raptor', 'bio' => 'Royale Air Force test pilot']);
        Person::create(['name' => 'Blackheart', 'bio' => 'The dreaded captain of the stormy seas.']);
        Person::create(['name' => 'Jekyll', 'bio' => "He's got some inner demons."]);
        Person::create(['name' => 'Power Chord', 'bio' => 'Bring on the noise complaints.']);
        Person::create(['name' => 'Stage Slayer', 'bio' => 'Crank it up!']);
        Person::create(['name' => 'Willow', 'bio' => 'A wandering spirit with unfinished buissness.']);
        Person::create(['name' => 'Cobb', 'bio' => 'Shake off that husk and grab some butter.']);
        Person::create(['name' => 'Zenith', 'bio' => 'Peak performance at any elevation.']);

        /*
         * Test 2: Posts
         */
        $post = Post::create(['name' => 'First post, yay!', 'content' => 'I have some comments!']);
        Post::create(['name' => 'A content image', 'content' => 'I have no comments']);

        $post->comments()->create([
            'name' => 'deadmau5',
            'content' => "Rippin' my heart was so easy, so easy. Launch your assault now, take it easy. Raise your weapon, raise your weapon. One word and it's over",
        ]);

        $post->comments()->create([
            'name' => 'Hidden comment',
            'content' => 'This comment should be hidden as defined in the relationship.',
            'is_visible' => false,
        ]);

        /*
         * Test 3: Users
         */
        User::make(['username' => 'Neo', 'security_code' => '1111'])->forceSave();
        User::make(['username' => 'Morpheus', 'security_code' => '8888'])->forceSave();

        $role = Role::create(['name' => 'Chief Executive Orangutan', 'description' => 'You can call this person CEO for short']);
        Role::create(['name' => 'Chief Friendship Organiser', 'description' => 'You can call this person CFO for short']);
        Role::create(['name' => 'Caring Technical Officer', 'description' => 'You can call this person CTO for short']);

        $user = User::first();
        $user->roles()->add($role, null, ['clearance_level' => 'Top Secret', 'is_executive' => true]);

        $post->user()->add($user);
        $post->save();

        foreach (range(1, 20) as $index) {
            Role::create([
                'name' => 'Roles test ' . ($index + 1),
                'description' => 'Roles for relation test',
                'users' => [$user->id],
            ]);
        }

        /*
         * Test 4: Countries
         */
        $country1 = Country::create([
            'name' => 'Petoria',
            'code' => 'petoria',
            'language' => 'eh',
            'currency' => 'btc',
            'is_active' => false,
            'states' => [
                ['title' => 'Stewie'],
                ['title' => 'Brian'],
                ['title' => 'Chris'],
                ['title' => 'Lois'],
                ['title' => 'Meg'],
            ],
        ]);

        $user = User::first();
        $user->country()->add($country1);
        $user->forceSave();

        $country2 = Country::create([
            'name' => 'Blueseed',
            'code' => 'blueseed',
            'language' => 'bs',
            'currency' => 'btc',
            'is_active' => false,
            'states' => [
                ['title' => 'Boaty'],
                ['title' => 'McBoat'],
                ['title' => 'Face'],
            ],
        ]);

        /*
         * Test 4a: Locations
         */
        $cities = [
            $country1->id => ['Regina', 'Vancouver', 'Toronto', 'Ottawa'],
            $country2->id => ['New York', 'Seattle', 'Boston', 'San Francisco'],
        ];

        $insertCities = [];
        foreach ($cities as $countryId => $cityNames) {
            foreach ($cityNames as $name) {
                $insertCities[] = ['custom_country_id' => $countryId, 'name' => $name];
            }
        }

        City::insert($insertCities);
        Location::insert([
            ['country_id' => $country1->id, 'city_id' => 1, 'name' => '240 5th Ave'],
            ['country_id' => $country1->id, 'city_id' => 2, 'name' => '101 McKay Street'],
            ['country_id' => $country1->id, 'city_id' => 3, 'name' => '123 Nowhere Lane'],
            ['country_id' => $country1->id, 'city_id' => 4, 'name' => '10099 Bob Loop'],
            ['country_id' => $country2->id, 'city_id' => 5, 'name' => '9442 Scary Street'],
            ['country_id' => $country2->id, 'city_id' => 6, 'name' => '5309 Imagination Crescrent'],
            ['country_id' => $country2->id, 'city_id' => 7, 'name' => '22 2201 Seymour Drive'],
            ['country_id' => $country2->id, 'city_id' => 8, 'name' => '2322 Xray Alphabet'],
        ]);

        /*
         * Test 4b: Regions
         */
        $country = Country::create([
            'name' => 'Dimension C-137',
            'code' => 'dimension-c-137',
            'language' => 'bp',
            'currency' => 'smk',
            'is_active' => false,
        ]);

        foreach (range(1, 1000) as $index) {
            City::create([
                'name' => 'City test ' . Str::random(),
                'country' => $country,
            ]);
        }

        /*
         * Test 5: Reviews
         */
        Review::create(['content' => 'Orphan review', 'is_positive' => false, 'feature_color' => '#000000']);
        $review = Review::create(['content' => 'Excellent design work', 'is_positive' => true, 'feature_color' => '#CCCCCC']);

        $theme = Theme::create(['name' => 'Bootstrap', 'code' => 'bootstrap', 'content' => 'A bootstrap theme.']);
        $theme->reviews()->add($review);

        Plugin::create(['name' => 'Angular', 'code' => 'angular', 'content' => 'An AngularJS plugin.']);

        /*
         * Test 6: Trees
         */
        $fourUpManager = Member::create(['name' => 'Khaleesi']);
        $threeUpManager = Member::create(['name' => 'Ian', 'parent_id' => $fourUpManager->id]);
        $twoUpManager = Member::create(['name' => 'Vangelis', 'parent_id' => $threeUpManager->id]);
        $oneUpManager = Member::create(['name' => 'Joe', 'parent_id' => $twoUpManager->id]);
        Member::create(['name' => 'Johnny', 'user_id' => $user->id, 'parent_id' => $oneUpManager->id]);
        Member::create(['name' => 'Sally', 'user_id' => $user->id, 'parent_id' => $oneUpManager->id]);
        Member::create(['name' => 'Rick', 'user_id' => $user->id, 'parent_id' => $oneUpManager->id]);

        $orange = Channel::create(['title' => 'Channel Orange', 'description' => 'A root level forum channel', 'user_id' => $user->id]);
        $autumn = $orange->children()->create(['title' => 'Autumn Leaves', 'description' => 'Disccusion about the season of falling leaves.']);
        $autumn->children()->create(['title' => 'September', 'description' => 'The start of the fall season.']);
        $october = $autumn->children()->create(['title' => 'October', 'description' => 'The middle of the fall season.']);
        $autumn->children()->create(['title' => 'November', 'description' => 'The end of the fall season.']);
        $orange->children()->create(['title' => 'Summer Breeze', 'description' => 'Disccusion about the wind at the ocean.']);

        $green = Channel::create(['title' => 'Channel Green', 'description' => 'A root level forum channel', 'user_id' => $user->id]);
        $green->children()->create(['title' => 'Winter Snow', 'description' => 'Disccusion about the frosty snow flakes.']);
        $green->children()->create(['title' => 'Spring Trees', 'description' => 'Disccusion about the blooming gardens.']);

        $parent = Category::create(['name' => 'Web', 'description' => 'Websites & Web Applications']);
        Category::create(['name' => 'Create a website', 'parent_id' => $parent->id]);
        Category::create(['name' => 'Convert a template to a website', 'parent_id' => $parent->id]);

        $parent = Category::create(['name' => 'Desktop', 'description' => 'Desktop Software']);
        Category::create(['name' => 'Write software for Windows', 'parent_id' => $parent->id]);
        Category::create(['name' => 'Write software for Mac', 'parent_id' => $parent->id]);
        Category::create(['name' => 'Write software for Linux', 'parent_id' => $parent->id]);

        $parent = Category::create(['name' => 'Mobile', 'description' => 'Mobile Apps']);
        Category::create(['name' => 'Write software for iPhone / iPad', 'parent_id' => $parent->id]);
        Category::create(['name' => 'Write software for Android', 'parent_id' => $parent->id]);
        Category::create(['name' => 'Create a mobile website', 'parent_id' => $parent->id]);

        /*
         * Test 7: Galleries
         */
        $gallery = Gallery::create(['title' => 'FEATURED WATERCREST', 'subtitle' => 'experience the flow', 'start_date' => now(), 'end_date' => now()->addDay()]);
        $gallery->posts()->add(Post::first());

        /*
         * Test 8: Pages
         */
        $layout1 = Layout::create([
            'content' => 'Yes',
        ]);

        $layout2 = Layout::create([
            'content' => 'No',
        ]);

        $pages = [
            [
                'id' => 1,
                'title' => 'First Page',
                'layout_id' => $layout1->id,
                'type' => 1,
                'content' => [
                    'title' => 'This is a simple page',
                    'content' => '<h1>Hello, World</h1>',
                ],
            ],
            [
                'id' => 2,
                'title' => 'Second Page',
                'layout_id' => $layout2->id,
                'type' => 2,
                'content' => [
                    'title' => 'This is a complex page',
                    'content' => '<h1>Hello, Complex World</h1>',
                    'meta_description' => 'Meta Description',
                    'meta_tags' => ['October CMS', 'Fun'],
                    'colors' => [
                        'primary' => '#ff0000',
                        'secondary' => '#00ff00',
                    ],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Third Page',
                'parent_id' => 1,
                'layout_id' => $layout1->id,
                'type' => 2,
                'content' => [
                    'title' => 'This is a child page',
                    'content' => '<h1>Having too much fun</h1>',
                ],
            ],
        ];
        foreach ($pages as $page) {
            Page::create($page);
        }

        /*
         * Test 9: Product
         */
        $company1 = Company::create(['name' => 'Tezla']);
        $company2 = Company::create(['name' => 'Neztle']);
        $company3 = Company::create(['name' => 'Zubway']);
        $company4 = Company::create(['name' => 'Zoogle']);

        $product1 = Product::make(['title' => '2 Pizzas', 'price' => '49.95']);
        $product1->slug = 'custom-slug';
        $product1->company = $company1;
        $product1->savePropagate();

        $product2 = Product::make(['title' => 'Cola', 'price' => '4.99']);
        $product2->company = $company2;
        $product2->savePropagate();

        // Testing soft deletes
        $company2->delete();
        $company3->delete();
        $company4->delete();

        $category1 = ProductCategory::create(['name' => 'Food', 'description' => 'Chocolate fruit cake with beans on it']);
        $category2 = ProductCategory::create(['name' => 'Drink', 'description' => 'The balance has been restored']);

        $product1->categories()->add($category1);
        $product2->categories()->add($category2);

        $category1->savePropagate();
        $category2->savePropagate();

        $mains = ProductCategory::create(['name' => 'Mains', 'description' => 'We have been to town and back']);
        ProductCategory::create(['name' => 'Entree', 'description' => 'I hope you enjoyed the show']);
        ProductCategory::create(['name' => 'Dessert', 'description' => "I've never seen a diamond in the flesh"]);
        ProductCategory::create(['name' => 'Beverages', 'description' => "I cut my teeth on wedding rings in the movies"]);
        $chicken = ProductCategory::create(['name' => 'Chicken', 'description' => "And I'm not proud of my address"]);
        $fish = ProductCategory::create(['name' => 'Fish', 'description' => "In a torn up town, no postcode envy"]);
        $beef = ProductCategory::create(['name' => 'Beef', 'description' => "Gold teeth, Grey Goose, trippin' in the bathroom"]);
        $veg = ProductCategory::create(['name' => 'Vegetables', 'description' => "Bloodstains, ball gowns, trashin' the hotel room"]);
        ProductCategory::create(['name' => 'Souvenirs', 'description' => "We're driving Cadillacs in our dreams"]);
        ProductCategory::create(['name' => 'Candy', 'description' => "Cristal, Maybach, diamonds on your timepiece"]);
        ProductCategory::create(['name' => 'Automotive', 'description' => "Jet planes, islands, tigers on a gold leash"]);
        ProductCategory::create(['name' => 'Pets', 'description' => "My friends and I, we've cracked the code"]);
        ProductCategory::create(['name' => 'Hats', 'description' => "We count our dollars on the train to the party"]);
        ProductCategory::create(['name' => 'Jackets', 'description' => "And everyone who knows us knows"]);
        ProductCategory::create(['name' => 'Shoes', 'description' => "That we're fine with this, we didn't come from money"]);
        ProductCategory::create(['name' => 'Pants', 'description' => "It don't run in our blood"]);
        ProductCategory::create(['name' => 'Jewelry', 'description' => "That kind of luxe just ain't for us"]);
        ProductCategory::create(['name' => 'Eyewear', 'description' => "We crave a different kind of buzz"]);
        ProductCategory::create(['name' => 'Soap', 'description' => "Let me be your ruler (ruler)"]);
        ProductCategory::create(['name' => 'Perfume', 'description' => "You can call me queen bee"]);
        ProductCategory::create(['name' => 'Cologne', 'description' => "And baby, I'll rule (I'll rule, I'll rule, I'll rule)"]);
        ProductCategory::create(['name' => 'Gifts', 'description' => "Let me live that fantasy"]);

        $mains->savePropagate();
        $chicken->savePropagate();
        $fish->savePropagate();
        $beef->savePropagate();
        $veg->savePropagate();

        $chicken->makeChildOf($mains);
        $fish->makeChildOf($mains);
        $beef->makeChildOf($mains);
        $veg->makeChildOf($mains);

        /*
         * General Test: Attributes
         */
        $generalStatus = [
            ['name' => 'Draft', 'code' => 'draft'],
            ['name' => 'Pending', 'code' => 'pending'],
            ['name' => 'Rejected', 'code' => 'rejected'],
            ['name' => 'Active', 'code' => 'active'],
            ['name' => 'Suspended', 'code' => 'suspended'],
            ['name' => 'Expired', 'code' => 'expired'],
            ['name' => 'Cancelled', 'code' => 'cancelled'],
            ['name' => 'Completed', 'code' => 'completed'],
            ['name' => 'Closed', 'code' => 'closed'],
        ];

        $generalTypes = [
            ['name' => 'Warrior', 'label' => 'Tank, Melee Damage Dealer', 'code' => 'warrior'],
            ['name' => 'Paladin', 'label' => 'Tank, Healer, Melee Damage Dealer', 'code' => 'paladin'],
            ['name' => 'Hunter', 'label' => 'Ranged Physical Damage Dealer', 'code' => 'hunter'],
            ['name' => 'Rogue', 'label' => 'Melee Damage Dealer', 'code' => 'rogue'],
            ['name' => 'Priest', 'label' => 'Healer, Ranged Magic Damage Dealer', 'code' => 'priest'],
            ['name' => 'Death Knight', 'label' => 'Tank, Melee Damage Dealer', 'code' => 'death-knight'],
            ['name' => 'Shaman', 'label' => 'Healer, Ranged Magic Damage Dealer, Melee Damage Dealer', 'code' => 'shaman'],
            ['name' => 'Mage', 'label' => 'Ranged Magic Damage Dealer', 'code' => 'mage'],
            ['name' => 'Warlock', 'label' => 'Ranged Magic Damage Dealer', 'code' => 'warlock'],
            ['name' => 'Monk', 'label' => 'Tank, Healer, Melee Damage Dealer', 'code' => 'monk'],
            ['name' => 'Druid', 'label' => 'Tank, Healer, Ranged Magic Damage Dealer, Melee Damage Dealer', 'code' => 'druid'],
            ['name' => 'Demon Hunter', 'label' => 'Melee Damage Dealer, Tank', 'code' => 'demon-hunter'],
        ];

        $map = [
            Attribute::GENERAL_STATUS => $generalStatus,
            Attribute::GENERAL_TYPE => $generalTypes,
        ];

        foreach ($map as $type => $items) {
            foreach ($items as $data) {
                Attribute::create(array_merge($data, ['type' => $type]));
            }
        }
    }
}
