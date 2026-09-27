/*
 * Raw TipTap control, mounts the vendor_drm/tiptap bundle directly without the Vue connector
 *
 * Data attributes:
 * - data-control="tiptap-raw" - mounts TipTap and syncs its HTML to the inner textarea
 */

'use strict';

oc.registerControl('tiptap-raw', class extends oc.ControlBase {
    connect() {
        this.textarea = this.element.querySelector('textarea');
        this.editorElement = this.element.querySelector('[data-tiptap-editor]');
        this.editorElement.replaceChildren();

        this.editor = new TiptapEditor.Editor({
            element: this.editorElement,
            extensions: [TiptapEditor.StarterKit],
            content: this.textarea.value,
            editorProps: {
                attributes: { class: 'form-control', style: 'min-height: 300px' }
            },
            onUpdate: ({ editor }) => {
                this.textarea.value = editor.getHTML();
            }
        });
    }

    disconnect() {
        this.editor.destroy();
        this.editor = null;
        this.editorElement = null;
        this.textarea = null;
    }
});
