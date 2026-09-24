/*
 * Solution 1: Register a button
 *
 * Registers a custom command with the rich editor. The button is available
 * to any toolbar definition that includes it by name, for example, adding
 * insertCustomThing to a toolbar in Settings → Editor Settings.
 */
oc.richEditor.registerButton('insertCustomThing', {
    label: 'Insert Something',
    icon: 'icon-star',
    undo: true,
    focus: true,
    onClick: function(editor) {
        editor.insertHtml('<strong>My Custom Thing!</strong>');
    }
});

/*
 * Solution 2: Include the button in the default toolbar
 *
 * The toolbar property places the button automatically when the editor uses
 * the default button set: 'start', 'end', { before: 'name' } or { after: 'name' }.
 */
oc.richEditor.registerButton('insertOtherThing', {
    label: 'Insert Other Thing',
    icon: 'icon-bolt',
    toolbar: 'end',
    separator: 'before',
    onClick: function(editor) {
        editor.insertHtml('<em>My Other Thing!</em>');
    }
});

/*
 * @deprecated pathway registers the command using the legacy Froala
 * configuration, included here to confirm backwards compatibility
 */
oc.richEditorRegisterButton('insertLegacyThing', {
    title: 'Insert Legacy Thing',
    icon: '<i class="icon-history"></i>',
    undo: true,
    focus: true,
    refreshOnCallback: true,
    toolbar: 'end',
    callback: function () {
        this.html.insert('<u>My Legacy Thing!</u>');
    }
});
