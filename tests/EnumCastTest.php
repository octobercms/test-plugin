<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\Widgets\Form;
use Backend\Widgets\Lists;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Controllers\Posts;
use October\Test\Classes\StatusEnum;
use Backend\Models\User as BackendUser;

/**
 * EnumCastTest checks an attribute cast to a backed enum works in forms and lists.
 */
class EnumCastTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * setUp signs in a backend user, since the form and list widgets load preferences for the current user.
     */
    public function setUp(): void
    {
        parent::setUp();

        $superUser = new BackendUser;
        $superUser->login = 'tester';
        $superUser->is_superuser = true;

        $this->actingAs($superUser);
    }

    /**
     * testStatusIsCastToEnum checks the status stores the enum value and reads back the enum case.
     */
    public function testStatusIsCastToEnum()
    {
        $comment = $this->makeComment(StatusEnum::Approved);

        $this->assertSame(StatusEnum::Approved, $comment->fresh()->status);
        $this->assertEquals('approved', $comment->getRawOriginal('status'));
    }

    /**
     * testFormDropdownSelectsEnumValue checks the dropdown receives the enum value and the enum option labels.
     */
    public function testFormDropdownSelectsEnumValue()
    {
        $comment = $this->makeComment(StatusEnum::Rejected)->fresh();

        $controller = new Posts;
        $config = $controller->makeConfig('$/october/test/models/comment/fields.yaml');
        $config->model = $comment;
        $config->alias = 'commentForm';

        $form = $controller->makeWidget(Form::class, $config);
        $form->bindToController();
        $field = $form->getField('status');

        $this->assertSame('rejected', $field->value);
        $this->assertEquals('Rejected', $field->options()['rejected']);
    }

    /**
     * testListColumnShowsEnumLabel checks the selectable column shows the option label for the enum value.
     */
    public function testListColumnShowsEnumLabel()
    {
        $comment = $this->makeComment(StatusEnum::Published)->fresh();

        $controller = new Posts;
        $config = $controller->makeConfig('$/october/test/models/comment/columns.yaml');
        $config->model = new Comment;
        $config->alias = 'commentList';

        $list = $controller->makeWidget(Lists::class, $config);
        $column = $list->getVisibleColumns()['status'];

        $this->assertEquals('Published', trim($list->getColumnValue($comment, $column)));
    }

    /**
     * makeComment creates a comment on a new post with the given status.
     */
    protected function makeComment(StatusEnum $status): Comment
    {
        $post = Post::create(['name' => 'Enum post']);

        $comment = new Comment;
        $comment->name = 'Enum comment';
        $comment->status = $status;
        $comment->post = $post;
        $comment->save();

        return $comment;
    }
}
