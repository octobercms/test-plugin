<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Test\Models\Post;

/**
 * TiptapController compares the Vue rich editor, raw Froala and TipTap side by side
 */
class TiptapController extends Controller
{
    /**
     * @var array requiredPermissions to view this page
     */
    public $requiredPermissions = ['october.test.access_plugin'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'tiptap');
    }

    /**
     * index renders the editor comparison form
     */
    public function index()
    {
        $this->pageTitle = 'Rich Editors';

        $this->addCss('/modules/system/assets/vendor/froala/froala.css');
        $this->addJs('/plugins/october/test/assets/js/froala-raw.js');
        $this->addTiptapAssets();

        $this->vars['formWidget'] = $this->makeEditorsForm();
    }

    /**
     * addTiptapAssets includes the bundle built by npm run build, versioned by file time so rebuilds skip the cache
     */
    protected function addTiptapAssets()
    {
        $bundlePath = plugins_path('october/test/assets/vendor/tiptap/tiptap.js');
        if (!is_file($bundlePath)) {
            return;
        }

        $stylePath = plugins_path('october/test/assets/vendor/tiptap/tiptap.css');
        if (is_file($stylePath)) {
            $this->addCss('/plugins/october/test/assets/vendor/tiptap/tiptap.css?v=' . filemtime($stylePath));
        }

        $this->addJs('/plugins/october/test/assets/vendor/tiptap/tiptap.js?v=' . filemtime($bundlePath));
        $this->addJs('/plugins/october/test/assets/js/tiptap-raw.js?v=' . filemtime(plugins_path('october/test/assets/js/tiptap-raw.js')));
    }

    /**
     * makeEditorsForm builds the form widget, the unsaved model only satisfies the widget
     */
    protected function makeEditorsForm()
    {
        $sample = $this->getSampleContent();

        $config = $this->makeConfig('fields.yaml');
        $config->model = new Post;
        $config->data = [
            'vue_editor' => $sample,
            'froala_editor' => $sample,
            'tiptap_editor' => $sample,
            'tiptap_full_editor' => $sample,
        ];
        $config->arrayName = 'Editors';
        $config->context = 'create';

        $widget = $this->makeWidget(\Backend\Widgets\Form::class, $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     * getSampleContent returns the starting HTML shared by every editor, written the way Froala saves it
     */
    protected function getSampleContent(): string
    {
        return '<h2>Editor comparison</h2>'
            . '<p>Some <strong>bold</strong>, <em>italic</em> and <a href="https://octobercms.com">linked</a> text.</p>'
            . '<ul><li>First item</li><li>Second item</li></ul>'
            . '<p style="text-align: center;">A centered paragraph with <span class="oc-class-highlighted">highlighted</span> text.</p>'
            . '<p><img src="/modules/backend/assets/images/october-logo.svg" class="fr-fic fr-dib" style="width: 160px;"></p>'
            . '<table style="width: 100%;"><thead><tr><th>Name</th><th>Value</th></tr></thead>'
            . '<tbody><tr><td style="width: 50.0000%;">First</td><td style="width: 50.0000%;">One<br></td></tr></tbody></table>'
            . '<figure data-video="/storage/app/media/sample.mp4" data-label="sample.mp4">&nbsp;</figure>'
            . '<p>Download the <a href="/storage/app/media/document.pdf" class="fr-file">document.pdf</a> file.</p>'
            . '<p><br></p>';
    }
}
