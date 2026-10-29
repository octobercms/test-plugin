<?php namespace October\Test\Tests;

use PluginTestCase;
use October\Test\Models\Member;
use October\Test\Models\Category;
use October\Test\Models\Channel;

/**
 * TreeModelTest checks the SimpleTree and NestedTree traits link, nest, delete and restore tree records.
 */
class TreeModelTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testMemberSimpleTreeReadsChildrenAndParents checks members saved under a parent are read back as its children and descendants.
     */
    public function testMemberSimpleTreeReadsChildrenAndParents()
    {
        $manager = $this->makeMember('Manager');
        $lead = $this->makeMember('Lead', $manager);
        $this->makeMember('Assistant', $manager);
        $intern = $this->makeMember('Intern', $lead);

        $found = Member::find($manager->id);
        $this->assertEqualsCanonicalizing(['Lead', 'Assistant'], $found->children->pluck('name')->all());
        $this->assertEquals(3, $found->getChildCount());
        $this->assertEquals('Manager', Member::find($intern->id)->parent->parent->name);
    }

    /**
     * testCategorySimpleTreeReadsAllChildren checks getAllChildren returns every descendant of a category, nested or not.
     */
    public function testCategorySimpleTreeReadsAllChildren()
    {
        $software = $this->makeCategory('Software');
        $desktop = $this->makeCategory('Desktop Apps', $software);
        $this->makeCategory('Windows Apps', $desktop);
        $this->makeCategory('Mobile Apps', $software);

        $found = Category::find($software->id);
        $this->assertEqualsCanonicalizing(['Desktop Apps', 'Windows Apps', 'Mobile Apps'], $found->getAllChildren()->pluck('name')->all());
        $this->assertEquals('Software', Category::find($desktop->id)->parent->name);
    }

    /**
     * testChannelNestedTreeNestsChildren checks channels saved under a parent are nested inside its left and right values with their depth.
     */
    public function testChannelNestedTreeNestsChildren()
    {
        $root = $this->makeChannel('Root Channel');
        $child = $this->makeChannel('Child Channel', $root);
        $grandchild = $this->makeChannel('Grandchild Channel', $child);

        $root = Channel::find($root->id);
        $grandchild = Channel::find($grandchild->id);

        $this->assertEquals(['Child Channel'], $root->getChildren()->pluck('title')->all());
        $this->assertEquals(['Child Channel', 'Grandchild Channel'], $root->getAllChildren()->pluck('title')->all());
        $this->assertEquals(2, $root->getChildCount());
        $this->assertEquals(2, $grandchild->getDepth());
        $this->assertEquals($root->id, $grandchild->getRoot()->id);
        $this->assertTrue($grandchild->isLeaf());
        $this->assertGreaterThan($root->nest_left, $grandchild->nest_left);
        $this->assertLessThan($root->nest_right, $grandchild->nest_right);
    }

    /**
     * testChannelDeleteAndRestoreIncludeDescendants checks soft deleting a channel trashes its descendants and restoring it brings them back into the tree.
     */
    public function testChannelDeleteAndRestoreIncludeDescendants()
    {
        $root = $this->makeChannel('Seasons');
        $winter = $this->makeChannel('Winter', $root);
        $december = $this->makeChannel('December', $winter);

        Channel::find($winter->id)->delete();

        $this->assertNull(Channel::find($december->id));
        $this->assertNotNull(Channel::withTrashed()->find($december->id));
        $this->assertEquals(0, Channel::find($root->id)->getChildCount());

        Channel::withTrashed()->find($winter->id)->restore();

        $this->assertNotNull(Channel::find($december->id));
        $this->assertEquals(['Winter', 'December'], Channel::find($root->id)->getAllChildren()->pluck('title')->all());
    }

    /**
     * makeMember saves a member, optionally under a parent member.
     */
    protected function makeMember(string $name, ?Member $parent = null): Member
    {
        $member = new Member;
        $member->name = $name;

        if ($parent) {
            $member->parent = $parent;
        }

        $member->save();

        return $member;
    }

    /**
     * makeCategory saves a category, optionally under a parent category.
     */
    protected function makeCategory(string $name, ?Category $parent = null): Category
    {
        $category = new Category;
        $category->name = $name;

        if ($parent) {
            $category->parent = $parent;
        }

        $category->save();

        return $category;
    }

    /**
     * makeChannel saves a channel, optionally under a parent channel, where the NestedTree trait moves it into place after saving.
     */
    protected function makeChannel(string $title, ?Channel $parent = null): Channel
    {
        $channel = new Channel;
        $channel->title = $title;

        if ($parent) {
            $channel->parent_id = $parent->id;
        }

        $channel->save();

        return $channel;
    }
}
