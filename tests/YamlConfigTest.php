<?php namespace October\Test\Tests;

use Str;
use Yaml;
use PluginTestCase;
use ReflectionClass;
use Tailor\Classes\FieldManager;
use Backend\Classes\WidgetManager;

/**
 * YamlConfigTest checks every YAML file in the plugin parses, and that model configs and Tailor blueprints use keys, types and references the core reads.
 */
class YamlConfigTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * @var array|null blueprintIndex caches the plugin's blueprints by handle and uuid
     */
    protected $blueprintIndex;

    /**
     * testYamlFileIsValid checks the YAML file parses to an array, which covers the controller configs and blueprints too.
     * @dataProvider yamlFileProvider
     */
    public function testYamlFileIsValid(string $filePath)
    {
        $this->assertIsArray(Yaml::parseFile($filePath), basename($filePath) . ' should parse to an array');
    }

    /**
     * testModelFieldsYamlHasFieldsKey checks the model form fields file defines fields, tabs or secondary tabs.
     * @dataProvider modelFieldsProvider
     */
    public function testModelFieldsYamlHasFieldsKey(string $filePath)
    {
        $decoded = Yaml::parseFile($filePath);

        $hasFields = isset($decoded['fields'])
            || isset($decoded['tabs'])
            || isset($decoded['secondaryTabs']);

        $this->assertTrue(
            $hasFields,
            basename(dirname($filePath)) . '/fields.yaml should have a fields, tabs, or secondaryTabs key'
        );
    }

    /**
     * testModelColumnsYamlHasColumnsKey checks the model list columns file defines columns.
     * @dataProvider modelColumnsProvider
     */
    public function testModelColumnsYamlHasColumnsKey(string $filePath)
    {
        $this->assertArrayHasKey(
            'columns',
            Yaml::parseFile($filePath),
            basename(dirname($filePath)) . '/columns.yaml should have a columns key'
        );
    }

    /**
     * testBlueprintKeysAreCurrent checks every top-level key is one Tailor reads for the blueprint type, since unknown keys are silently ignored.
     * @dataProvider blueprintProvider
     */
    public function testBlueprintKeysAreCurrent(string $filePath)
    {
        $blueprint = Yaml::parseFile($filePath);
        $name = basename($filePath);
        $type = (string) ($blueprint['type'] ?? '');
        $allowedKeys = $this->getBlueprintKeys($type);

        $this->assertNotEmpty($allowedKeys, "{$name} has the unsupported blueprint type [{$type}]");

        foreach (array_keys($blueprint) as $key) {
            $this->assertContains($key, $allowedKeys, "{$name} has the top-level key [{$key}], which Tailor does not read for the {$type} type");
        }
    }

    /**
     * testBlueprintFieldTypesAreRegistered checks every field type is lowercase and names a backend form field, a form widget or a Tailor content field.
     * @dataProvider blueprintProvider
     */
    public function testBlueprintFieldTypesAreRegistered(string $filePath)
    {
        $name = basename($filePath);
        $registeredTypes = $this->getRegisteredFieldTypes();

        foreach ($this->collectFields(Yaml::parseFile($filePath)) as [$fieldName, $field]) {
            if (!is_string($type = $field['type'] ?? null)) {
                continue;
            }

            $this->assertEquals(strtolower($type), $type, "{$name} field [{$fieldName}] uses the type [{$type}], but Tailor matches field types in lowercase");
            $this->assertContains($type, $registeredTypes, "{$name} field [{$fieldName}] uses the type [{$type}], which is not a registered field type");
        }
    }

    /**
     * testBlueprintSourcesResolve checks every field source, including those inside forms and repeater groups, names a blueprint in this plugin, and a mixin source names a mixin.
     */
    public function testBlueprintSourcesResolve()
    {
        $blueprints = $this->getBlueprintIndex();
        $checked = 0;

        foreach (self::blueprintProvider() as [$filePath]) {
            foreach ($this->collectFields(Yaml::parseFile($filePath)) as [$fieldName, $field]) {
                if (!isset($field['source'])) {
                    continue;
                }

                $source = $field['source'];
                $location = basename($filePath) . " field [{$fieldName}]";
                $checked++;

                $this->assertArrayHasKey($source, $blueprints, "{$location} uses the source [{$source}], which no blueprint in the plugin defines");

                if (($field['type'] ?? null) === 'mixin') {
                    $this->assertEquals('mixin', $blueprints[$source]['type'] ?? null, "{$location} mixes in [{$source}], which is not a mixin blueprint");
                }
            }
        }

        $this->assertGreaterThan(0, $checked, 'No blueprint field has a source, so collectFields is not finding the fields');
    }

    /**
     * testBlueprintTitleFromNamesField checks every repeater titleFrom names a field in the form or group it titles, including fields from mixins.
     */
    public function testBlueprintTitleFromNamesField()
    {
        $checked = 0;

        foreach (self::blueprintProvider() as [$filePath]) {
            foreach ($this->collectFields(Yaml::parseFile($filePath)) as [$fieldName, $field]) {
                $location = basename($filePath) . " field [{$fieldName}]";

                if (isset($field['titleFrom'])) {
                    $itemForms = is_array($field['form'] ?? null) ? [$field['form']] : (array) ($field['groups'] ?? []);
                    $fieldNames = [];
                    $checked++;

                    foreach ($itemForms as $itemForm) {
                        $fieldNames = array_merge($fieldNames, $this->getFieldNames((array) $itemForm));
                    }

                    $this->assertContains($field['titleFrom'], $fieldNames, "{$location} sets titleFrom [{$field['titleFrom']}], which is not a field in its form");
                }

                foreach ((array) ($field['groups'] ?? []) as $groupName => $group) {
                    if (isset($group['titleFrom'])) {
                        $checked++;

                        $this->assertContains($group['titleFrom'], $this->getFieldNames((array) $group), "{$location} group [{$groupName}] sets titleFrom [{$group['titleFrom']}], which is not a field in the group");
                    }
                }
            }
        }

        $this->assertGreaterThan(0, $checked, 'No blueprint field sets titleFrom, so collectFields is not finding the repeaters');
    }

    /**
     * testModelBlueprintsShipWithPlugin checks every Tailor blueprint a model relates to is defined in this plugin.
     */
    public function testModelBlueprintsShipWithPlugin()
    {
        $shipped = array_map(fn($file) => Yaml::parseFile($file[0])['uuid'] ?? null, self::blueprintProvider());
        $referenced = [];

        foreach (glob(plugins_path('october/test/models/*.php')) as $path) {
            $class = 'October\Test\Models\\' . basename($path, '.php');

            foreach ((new ReflectionClass($class))->getDefaultProperties() as $definitions) {
                foreach (is_array($definitions) ? $definitions : [] as $relation => $definition) {
                    if (is_string($definition['blueprint'] ?? null)) {
                        $referenced["{$class}::{$relation}"] = $definition['blueprint'];
                    }
                }
            }
        }

        $this->assertNotEmpty($referenced);

        foreach ($referenced as $relation => $uuid) {
            $this->assertContains($uuid, $shipped, "{$relation} relates to blueprint [{$uuid}], which is not in the plugin's blueprints folder");
        }
    }

    /**
     * getBlueprintKeys returns the top-level keys Tailor reads for a blueprint type, taken from the core blueprint classes and the Tailor blueprint docs.
     */
    protected function getBlueprintKeys(string $type): array
    {
        $common = ['uuid', 'handle', 'type', 'name', 'fields'];

        $recordKeys = [
            'description', 'navigation', 'primaryNavigation', 'extraNavigation', 'permissions',
            'modelClass', 'customMessages', 'multisite', 'validation',
        ];

        $entryKeys = [
            'groups', 'columns', 'scopes', 'drafts', 'softDeletes', 'pagefinder',
            'defaultSort', 'showExport', 'showImport',
        ];

        return match ($type) {
            'mixin' => $common,
            'global' => [...$common, ...$recordKeys, 'formSize'],
            'entry', 'single', 'stream' => [...$common, ...$recordKeys, ...$entryKeys],
            'structure' => [...$common, ...$recordKeys, ...$entryKeys, 'structure'],
            'submission' => [...$common, ...$recordKeys, ...$entryKeys, 'submission'],
            default => [],
        };
    }

    /**
     * getRegisteredFieldTypes returns the backend form field types, the form widget codes and the Tailor content field codes.
     */
    protected function getRegisteredFieldTypes(): array
    {
        $types = array_map(
            fn($path) => Str::after(basename($path, '.php'), '_field_'),
            glob(base_path('modules/backend/widgets/form/partials/_field_*.php'))
        );

        foreach (WidgetManager::instance()->listFormWidgets() as $className => $widgetInfo) {
            $types[] = $widgetInfo['code'] ?? Str::getClassId($className);
        }

        foreach (FieldManager::instance()->listCustomFields() as $className => $fieldInfo) {
            $types[] = $fieldInfo['code'] ?? Str::getClassId($className);
        }

        return $types;
    }

    /**
     * getBlueprintIndex returns the plugin's blueprints keyed by both handle and uuid, the two ways a source can name a blueprint.
     */
    protected function getBlueprintIndex(): array
    {
        if ($this->blueprintIndex !== null) {
            return $this->blueprintIndex;
        }

        $this->blueprintIndex = [];

        foreach (self::blueprintProvider() as [$filePath]) {
            $blueprint = Yaml::parseFile($filePath);

            foreach (['handle', 'uuid'] as $key) {
                if (isset($blueprint[$key])) {
                    $this->blueprintIndex[$blueprint[$key]] = $blueprint;
                }
            }
        }

        return $this->blueprintIndex;
    }

    /**
     * getFieldNames returns the field names a form config defines, without context suffixes and with mixin fields expanded.
     */
    protected function getFieldNames(array $config, array $seenSources = []): array
    {
        $blueprints = $this->getBlueprintIndex();
        $names = [];

        foreach ($this->getFieldDefinitions($config) as $name => $field) {
            $source = $field['source'] ?? null;

            if (($field['type'] ?? null) === 'mixin' && isset($blueprints[$source]) && !in_array($source, $seenSources, true)) {
                $names = array_merge($names, $this->getFieldNames($blueprints[$source], [...$seenSources, $source]));
                continue;
            }

            $names[] = Str::before($name, '@');
        }

        return $names;
    }

    /**
     * collectFields returns every field in a blueprint as a name and config pair, including fields in groups and in nested forms.
     */
    protected function collectFields(array $config): array
    {
        $fields = [];

        foreach ($this->getFieldDefinitions($config) as $name => $field) {
            if (!is_array($field)) {
                continue;
            }

            $fields[] = [$name, $field];
            $fields = array_merge($fields, $this->collectFields($field));

            if (is_array($field['form'] ?? null)) {
                $fields = array_merge($fields, $this->collectFields($field['form']));
            }
        }

        foreach ((array) ($config['groups'] ?? []) as $group) {
            if (is_array($group)) {
                $fields = array_merge($fields, $this->collectFields($group));
            }
        }

        return $fields;
    }

    /**
     * getFieldDefinitions returns the field definitions of a form config, from its fields, tabs and secondary tabs.
     */
    protected function getFieldDefinitions(array $config): array
    {
        return (array) ($config['fields'] ?? [])
            + (array) ($config['tabs']['fields'] ?? [])
            + (array) ($config['secondaryTabs']['fields'] ?? []);
    }

    /**
     * yamlFileProvider returns every YAML file in the plugin, outside the dependency folders.
     */
    public static function yamlFileProvider(): array
    {
        return self::collectFiles(__DIR__ . '/..', '*.yaml');
    }

    /**
     * modelFieldsProvider returns all fields.yaml files
     */
    public static function modelFieldsProvider(): array
    {
        return self::collectFiles(__DIR__ . '/../models', 'fields.yaml');
    }

    /**
     * modelColumnsProvider returns all columns.yaml files
     */
    public static function modelColumnsProvider(): array
    {
        return self::collectFiles(__DIR__ . '/../models', 'columns.yaml');
    }

    /**
     * blueprintProvider returns all blueprint YAML files
     */
    public static function blueprintProvider(): array
    {
        return self::collectFiles(__DIR__ . '/../blueprints', '*.yaml');
    }

    /**
     * collectFiles collects files matching a pattern recursively, skipping the .git, node_modules and vendor folders.
     */
    protected static function collectFiles(string $basePath, string $pattern): array
    {
        $basePath = realpath($basePath);

        if (!$basePath) {
            return [];
        }

        $skippedFolders = ['.git', 'node_modules', 'vendor'];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator($basePath, \RecursiveDirectoryIterator::SKIP_DOTS),
                fn($file) => !$file->isDir() || !in_array($file->getFilename(), $skippedFolders, true)
            )
        );

        $data = [];
        foreach ($iterator as $file) {
            if ($file->isFile() && fnmatch($pattern, $file->getFilename())) {
                $relativePath = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $data[$relativePath] = [$file->getPathname()];
            }
        }

        return $data;
    }
}
