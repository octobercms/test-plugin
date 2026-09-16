<?php namespace October\Test\Tests;

use PluginTestCase;
use Backend\Widgets\Form;
use Backend\Classes\Controller;
use October\Test\Models\User;
use October\Test\Models\Country;

/**
 * RelationQuickCreateTest covers issue #811: the quick create option was
 * unselectable when the dropdown had no entries, since the sentinel option
 * became the default browser selection and never fired a change event.
 */
class RelationQuickCreateTest extends PluginTestCase
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
     * makeRelationWidget builds a relation form widget for the user country field.
     */
    protected function makeRelationWidget(array $fieldConfig = [])
    {
        $form = new Form(new Controller, [
            'model' => new User,
            'arrayName' => 'User',
            'fields' => [
                'country' => array_merge([
                    'label' => 'Country',
                    'type' => 'relation',
                    'nameFrom' => 'name',
                    'quickCreate' => ['optionText' => 'Create New Country'],
                ], $fieldConfig),
            ],
        ]);

        $form->bindToController();
        self::callProtectedMethod($form, 'defineFormFields');

        return $form->getFormWidget('country');
    }

    /**
     * renderField prepares the widget and returns the render form field.
     */
    protected function renderField($widget)
    {
        $widget->prepareVars();

        return $widget->renderFormField;
    }

    /**
     * testQuickCreateOptionIsPrepended
     */
    public function testQuickCreateOptionIsPrepended()
    {
        Country::query()->delete();
        Country::create(['name' => 'Testland']);

        $field = $this->renderField($this->makeRelationWidget());
        $options = $field->options();

        $this->assertSame('__quick_create__', array_key_first($options));
        $this->assertContains('Testland', $options);
    }

    /**
     * testPlaceholderAppliedWhenNoEntriesExist asserts the placeholder default,
     * which guarantees an empty option renders first so the sentinel option is
     * never the default browser selection.
     */
    public function testPlaceholderAppliedWhenNoEntriesExist()
    {
        Country::query()->delete();

        $field = $this->renderField($this->makeRelationWidget());
        $options = $field->options();

        $this->assertSame(['__quick_create__'], array_keys($options));
        $this->assertNotEmpty($field->placeholder);
    }

    /**
     * testExplicitPlaceholderIsPreserved
     */
    public function testExplicitPlaceholderIsPreserved()
    {
        Country::query()->delete();

        $field = $this->renderField($this->makeRelationWidget([
            'placeholder' => 'Choose a country'
        ]));

        $this->assertSame('Choose a country', $field->placeholder);
    }

    /**
     * testExplicitEmptyOptionDisablesPlaceholderDefault
     */
    public function testExplicitEmptyOptionDisablesPlaceholderDefault()
    {
        Country::query()->delete();

        $field = $this->renderField($this->makeRelationWidget([
            'emptyOption' => 'No Country'
        ]));

        $this->assertEmpty($field->placeholder);
        $this->assertSame('No Country', $field->getConfig('emptyOption'));
    }

    /**
     * testSentinelValueIsNeverSaved
     */
    public function testSentinelValueIsNeverSaved()
    {
        $widget = $this->makeRelationWidget();

        $this->assertNull($widget->getSaveValue('__quick_create__'));
    }

    /**
     * testNoPlaceholderDefaultWithoutQuickCreate
     */
    public function testNoPlaceholderDefaultWithoutQuickCreate()
    {
        Country::query()->delete();

        $field = $this->renderField($this->makeRelationWidget([
            'quickCreate' => null
        ]));

        $this->assertArrayNotHasKey('__quick_create__', $field->options());
        $this->assertEmpty($field->placeholder);
    }
}
