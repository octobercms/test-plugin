<?php namespace October\Test\Tests;

use Site;
use PluginTestCase;
use System\Models\File;
use System\Models\SiteDefinition;
use System\Models\TranslatableFile;
use October\Test\Models\Page;
use October\Test\Models\User;
use October\Test\Models\Country;
use October\Test\Models\Setting;

/**
 * TranslationTest checks the models that use core translation, which needs no translation plugin.
 */
class TranslationTest extends PluginTestCase
{
    /**
     * @var bool useTransactions isolates each test with a database transaction
     */
    protected $useTransactions = true;

    /**
     * tearDown clears the cached site list, since a site added by a test is rolled back with the test transaction.
     */
    public function tearDown(): void
    {
        Site::resetCache();

        parent::tearDown();
    }

    /**
     * testCountryTranslatesPlainAndJsonAttributes checks a string and a jsonable attribute keep their translations.
     */
    public function testCountryTranslatesPlainAndJsonAttributes()
    {
        $country = Country::create(['name' => 'Germany', 'code' => 'DE']);
        $country->setTranslation('name', 'fr', 'Allemagne');
        $country->setTranslation('states', 'fr', [['name' => 'Bavière']]);
        $country->save();

        $found = Country::find($country->id);
        $this->assertEquals('Germany', $found->name);
        $this->assertEquals('Allemagne', $found->getTranslation('name', 'fr'));
        $this->assertEquals([['name' => 'Bavière']], $found->getTranslation('states', 'fr'));
    }

    /**
     * testSettingTranslatesTitle checks a settings model stores translations alongside its JSON values.
     */
    public function testSettingTranslatesTitle()
    {
        $setting = Setting::instance();
        $setting->title = 'Hello';
        $setting->setTranslation('title', 'fr', 'Bonjour');
        $setting->save();

        Setting::clearInternalCache();
        $found = Setting::instance();

        $this->assertEquals('Hello', $found->title);
        $this->assertEquals('Bonjour', $found->getTranslation('title', 'fr'));
    }

    /**
     * testUserPortfolioUsesTranslatableFiles checks a portfolio file keeps a translated title after it is saved and reloaded.
     */
    public function testUserPortfolioUsesTranslatableFiles()
    {
        $user = new User;
        $user->username = 'translated portfolio';
        $user->forceSave();

        $file = $this->makeFile(TranslatableFile::class, 'sunset.jpg');
        $file->title = 'Sunset';
        $user->portfolio()->add($file);

        $file->setTranslation('title', 'fr', 'Coucher de soleil');
        $file->save();

        $found = User::find($user->id)->portfolio->first();
        $this->assertInstanceOf(TranslatableFile::class, $found);
        $this->assertEquals('Sunset', $found->title);
        $this->assertEquals('Coucher de soleil', $found->getTranslation('title', 'fr'));
    }

    /**
     * testPageTranslationIsSavedAndReadPerLocale checks page values edited in French are saved as translations and read back in a French site.
     */
    public function testPageTranslationIsSavedAndReadPerLocale()
    {
        $site = $this->makeSite('fr');
        $page = $this->makePage('Welcome', 'Welcome to the site');

        $page->setLocale('fr');
        $page->title = 'Bienvenue';
        $page->content = ['title' => 'Bienvenue sur le site'];
        $page->save();

        $french = Site::withContext($site->id, function () use ($page) {
            return Page::find($page->id);
        });

        $this->assertEquals('Bienvenue', $french->title);
        $this->assertEquals('Bienvenue sur le site', $french->content['title']);
        $this->assertEquals('Welcome', Page::find($page->id)->title);
        $this->assertEquals('Welcome to the site', Page::find($page->id)->content['title']);
    }

    /**
     * testPageAttachmentIsStoredPerLocale checks a French image is kept apart from the default image, while a locale without its own image falls back to the default one.
     */
    public function testPageAttachmentIsStoredPerLocale()
    {
        $page = $this->makePage('Gallery', 'Gallery page');
        $page->secondimage()->add($this->makeFile(File::class, 'english.jpg'));

        $page->setLocale('fr');
        $page->secondimage()->add($this->makeFile(File::class, 'french.jpg'));

        $this->assertEquals('english.jpg', Page::find($page->id)->secondimage->file_name);
        $this->assertEquals('french.jpg', Page::find($page->id)->setLocale('fr')->secondimage->file_name);
        $this->assertEquals('english.jpg', Page::find($page->id)->setLocale('de')->secondimage->file_name);
        $this->assertEquals(['fr'], Page::find($page->id)->getTranslatedAttachmentLocales('secondimage'));
    }

    /**
     * makePage saves a page with a title and the content title its rules require.
     */
    protected function makePage(string $title, string $contentTitle): Page
    {
        $page = new Page;
        $page->title = $title;
        $page->type = 1;
        $page->content = ['title' => $contentTitle];
        $page->save();

        return $page;
    }

    /**
     * makeFile returns an unsaved file record that points to no file on disk.
     */
    protected function makeFile(string $class, string $fileName): File
    {
        $file = new $class;
        $file->disk_name = uniqid() . '.jpg';
        $file->file_name = $fileName;
        $file->file_size = 1;
        $file->content_type = 'image/jpeg';

        return $file;
    }

    /**
     * makeSite saves an extra site that uses the locale.
     */
    protected function makeSite(string $locale): SiteDefinition
    {
        $site = new SiteDefinition;
        $site->name = 'Site ' . $locale;
        $site->code = 'site-' . $locale;
        $site->locale = $locale;
        $site->is_enabled = true;
        $site->is_enabled_edit = true;
        $site->save();

        Site::resetCache();

        return $site;
    }
}
