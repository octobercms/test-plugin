<?php namespace October\Test\Tests;

use PluginTestCase;

/**
 * LangFilesTest validates language files are well-formed
 */
class LangFilesTest extends PluginTestCase
{
    /**
     * @dataProvider langJsonProvider
     */
    public function testJsonLangFileIsValid($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = json_decode($content);

        $this->assertNotNull(
            $decoded,
            basename($filePath) . ' contains invalid JSON: ' . json_last_error_msg()
        );

        $this->assertIsObject(
            $decoded,
            basename($filePath) . ' should decode to a JSON object'
        );
    }

    /**
     * @dataProvider langJsonProvider
     */
    public function testJsonLangFileValuesAreStrings($filePath)
    {
        $content = file_get_contents($filePath);
        $decoded = json_decode($content, true);

        foreach ($decoded as $key => $value) {
            $this->assertIsString(
                $value,
                basename($filePath) . " key '{$key}' has a non-string value"
            );
        }
    }

    /**
     * @dataProvider langPhpProvider
     */
    public function testPhpLangFileReturnsArray($filePath)
    {
        $result = include $filePath;

        $this->assertIsArray(
            $result,
            basename(dirname($filePath)) . '/lang.php should return an array'
        );
    }

    /**
     * langJsonProvider returns all JSON lang files
     */
    public static function langJsonProvider(): array
    {
        $langPath = __DIR__ . '/../lang';
        $files = glob($langPath . '/*.json');

        $data = [];
        foreach ($files as $file) {
            $data[basename($file)] = [$file];
        }

        return $data;
    }

    /**
     * langPhpProvider returns all PHP lang files
     */
    public static function langPhpProvider(): array
    {
        $langPath = realpath(__DIR__ . '/../lang');
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($langPath, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $data = [];
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relativePath = str_replace($langPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $data[$relativePath] = [$file->getPathname()];
            }
        }

        return $data;
    }
}
