<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\Models\User;
use Backend\Widgets\Lists;
use Backend\Classes\Controller;
use October\Test\Models\Post;
use October\Test\Models\Person;
use October\Test\Models\Attribute;
use October\Test\Controllers\Posts;
use October\Test\Controllers\People;

/**
 * ListColumnsTest renders shared list columns through a Lists widget, as any list using them would.
 */
class ListColumnsTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * setUp signs in a backend user, since Lists loads column preferences for the current user.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->makeSuperUser());
    }

    /**
     * testStatusColumnSortsByOrderAndShowsName checks the relation column sorts by sort_order and displays the name.
     */
    public function testStatusColumnSortsByOrderAndShowsName()
    {
        // Sort order disagrees with both the status names and the post names
        $archived = $this->makeStatus('Archived', 2);
        $published = $this->makeStatus('Published', 1);

        $this->makePost('Alpha post', $archived);
        $this->makePost('Zulu post', $published);

        $list = $this->makeList(new Posts, '$/october/test/models/post/columns.yaml', new Post, [
            'defaultSort' => ['column' => 'status_sort_order', 'direction' => 'asc'],
        ]);

        $column = $list->getVisibleColumns()['status_sort_order'];
        $records = $list->prepareQuery()->whereIn('name', ['Alpha post', 'Zulu post'])->get();

        $this->assertEquals(['Zulu post', 'Alpha post'], $records->pluck('name')->all());
        $this->assertEquals('Published', trim($list->getColumnValue($records[0], $column)));
        $this->assertEquals('Archived', trim($list->getColumnValue($records[1], $column)));
    }

    /**
     * testPersonNamePartialEscapesValue checks the name column partial escapes the value it prints.
     */
    public function testPersonNamePartialEscapesValue()
    {
        $person = new Person;
        $person->name = '<b>Bold</b>';
        $person->save();

        $list = $this->makeList(new People, '$/october/test/models/person/columns.yaml', new Person);
        $column = $list->getVisibleColumns()['name'];
        $html = $list->getColumnValue($person, $column);

        $this->assertStringContainsString('&lt;b&gt;Bold&lt;/b&gt;', $html);
        $this->assertStringNotContainsString('<b>', $html);
    }

    /**
     * makeList builds a Lists widget from a columns file, the way ListController does.
     */
    protected function makeList(Controller $controller, string $columnsPath, $model, array $options = []): Lists
    {
        $config = $controller->makeConfig($columnsPath);
        $config->model = $model;
        $config->alias = 'testList';

        foreach ($options as $key => $value) {
            $config->{$key} = $value;
        }

        return $controller->makeWidget(Lists::class, $config);
    }

    /**
     * makeSuperUser returns an unsaved backend superuser to sign in with.
     */
    protected function makeSuperUser(): User
    {
        $user = new User;
        $user->login = 'tester';
        $user->is_superuser = true;

        return $user;
    }

    /**
     * makeStatus creates a post status attribute.
     */
    protected function makeStatus(string $name, int $sortOrder): Attribute
    {
        $status = new Attribute;
        $status->type = 'general.status';
        $status->name = $name;
        $status->sort_order = $sortOrder;
        $status->save();

        return $status;
    }

    /**
     * makePost creates a post with the given status.
     */
    protected function makePost(string $name, Attribute $status): Post
    {
        $post = new Post;
        $post->name = $name;
        $post->status = $status;
        $post->save();

        return $post;
    }
}
