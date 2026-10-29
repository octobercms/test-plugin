<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\Classes\FormField;
use October\Rain\Database\Model;
use October\Test\Models\Tag;
use October\Test\Models\Post;
use October\Test\Models\Comment;
use October\Test\Controllers\Posts;
use Backend\Models\User as BackendUser;

/**
 * PostsControllerTest checks the Posts controller changes a post form field before display and picks the comment and tag forms.
 */
class PostsControllerTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * setUp signs in a backend user, since the form widgets load preferences for the current user.
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
     * testPostNameCommentShowsLowercasedName checks formExtendFields sets the name comment on the post form and leaves the name value unchanged.
     */
    public function testPostNameCommentShowsLowercasedName()
    {
        $post = new Post;
        $post->name = 'Hello World';
        $post->save();

        $field = $this->makeNameField(new Posts, $post);

        $this->assertEquals('Lowercased: hello World', $field->comment);
        $this->assertEquals('Hello World', $field->value);
    }

    /**
     * testCommentAndTagFormsKeepNameComment checks the comment and tag forms, picked by the posted comment_mode and tag_mode flags, get no name comment.
     */
    public function testCommentAndTagFormsKeepNameComment()
    {
        $comment = new Comment;
        $comment->name = 'Hello Comment';

        $tag = new Tag;
        $tag->name = 'Hello Tag';

        $commentController = $this->makeControllerWithPost(['comment_mode' => 1]);
        $commentField = $this->makeNameField($commentController, $comment);

        $tagController = $this->makeControllerWithPost(['tag_mode' => 1]);
        $tagField = $this->makeNameField($tagController, $tag);

        $this->assertEquals('Comment', $commentController->formGetConfig()->name);
        $this->assertEquals('Tag', $tagController->formGetConfig()->name);
        $this->assertSame('', $commentField->comment);
        $this->assertSame('', $tagField->comment);
    }

    /**
     * makeControllerWithPost creates the controller after posting the data, since the constructor picks the form config from the posted mode flag.
     */
    protected function makeControllerWithPost(array $data): Posts
    {
        request()->setMethod('POST');
        request()->request->replace($data);

        return new Posts;
    }

    /**
     * makeNameField initializes the update form for the model the way FormController does and returns its name field.
     */
    protected function makeNameField(Posts $controller, Model $model): FormField
    {
        $controller->initForm($model, 'update');

        return $controller->formGetWidget()->getField('name');
    }
}
