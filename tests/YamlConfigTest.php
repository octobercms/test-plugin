<?php namespace October\Test\Tests;

use Yaml;
use PluginTestCase;

/**
 * YamlConfigTest validates all YAML configuration files are well-formed
 */
class YamlConfigTest extends PluginTestCase
{
    /**
     * @dataProvider yamlFileProvider
     */
    public function testYamlFileIsValid($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = Yaml::parse($content);

        $this->assertNotNull(
            $decoded,
            basename($filePath) . ' could not be parsed as YAML'
        );
    }

    /**
     * @dataProvider modelFieldsProvider
     */
    public function testModelFieldsYamlHasFieldsKey($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = Yaml::parse($content);

        $hasFields = isset($decoded['fields'])
            || isset($decoded['tabs'])
            || isset($decoded['secondaryTabs']);

        $this->assertTrue(
            $hasFields,
            basename(dirname($filePath)) . '/fields.yaml should have a fields, tabs, or secondaryTabs key'
        );
    }

    /**
     * @dataProvider modelColumnsProvider
     */
    public function testModelColumnsYamlHasColumnsKey($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = Yaml::parse($content);

        $this->assertArrayHasKey(
            'columns',
            $decoded,
            basename(dirname($filePath)) . '/columns.yaml should have a columns key'
        );
    }

    /**
     * @dataProvider controllerConfigProvider
     */
    public function testControllerConfigYamlIsValid($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = Yaml::parse($content);

        $this->assertIsArray(
            $decoded,
            basename(dirname($filePath)) . '/' . basename($filePath) . ' should parse to an array'
        );
    }

    /**
     * @dataProvider blueprintProvider
     */
    public function testBlueprintYamlIsValid($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = Yaml::parse($content);

        $this->assertIsArray(
            $decoded,
            basename($filePath) . ' should parse to an array'
        );
    }

    /**
     * yamlFileProvider returns all YAML files in the plugin
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
     * controllerConfigProvider returns all controller config YAML files
     */
    public static function controllerConfigProvider(): array
    {
        return self::collectFiles(__DIR__ . '/../controllers', 'config_*.yaml');
    }

    /**
     * blueprintProvider returns all blueprint YAML files
     */
    public static function blueprintProvider(): array
    {
        return self::collectFiles(__DIR__ . '/../blueprints', '*.yaml');
    }

    /**
     * collectFiles collects YAML files matching a pattern recursively
     */
    protected static function collectFiles(string $basePath, string $pattern): array
    {
        $basePath = realpath($basePath);

        if (!$basePath) {
            return [];
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \RecursiveDirectoryIterator::SKIP_DOTS)
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
