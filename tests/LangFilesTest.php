<?php namespace October\Test\Tests;

use App;
use PluginTestCase;

/**
 * LangFilesTest validates language files are well-formed and that the regional fr-ca file falls back to fr.
 */
class LangFilesTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * testJsonLangFileIsValid checks the JSON language file decodes to an object.
     * @dataProvider langJsonProvider
     */
    public function testJsonLangFileIsValid(string $filePath)
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
     * testJsonLangFileValuesAreStrings checks every translation in the JSON language file is a string.
     * @dataProvider langJsonProvider
     */
    public function testJsonLangFileValuesAreStrings(string $filePath)
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
     * testPhpLangFileReturnsArray checks the PHP language file returns an array.
     * @dataProvider langPhpProvider
     */
    public function testPhpLangFileReturnsArray(string $filePath)
    {
        $result = include $filePath;

        $this->assertIsArray(
            $result,
            basename(dirname($filePath)) . '/lang.php should return an array'
        );
    }

    /**
     * testRegionalLocaleFallsBackToLanguage checks fr-ca reads the keys it leaves out from lang/fr, with fr as the fallback locale that October derives for a fr-ca site or backend user.
     */
    public function testRegionalLocaleFallsBackToLanguage()
    {
        App::setFallbackLocale('fr');

        $this->assertEquals('Test List in French', __('october.test::lang.test.component_name', [], 'fr-ca'));
        $this->assertEquals('Displays a list in French.', __('october.test::lang.test.component_description', [], 'fr-ca'));
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
