/*
 * Raw TipTap control, mounts the vendor_drm/tiptap rich editor directly without the Vue connector
 *
 * Data attributes:
 * - data-control="tiptap-raw" - mounts the editor and syncs its HTML to the inner textarea
 * - data-use-media-manager="true" - enables the media manager insert options
 * - data-toolbar-buttons="bold, italic" - toolbar buttons, the backend default list when omitted
 */

'use strict';

oc.registerControl('tiptap-raw', class extends oc.ControlBase {
    connect() {
        this.textarea = this.element.querySelector(':scope > textarea');
        this.editorElement = this.element.querySelector('[data-tiptap-editor]');
        this.outputElement = this.element.querySelector('[data-tiptap-output]');
        this.editorElement.replaceChildren();

        this.richEditor = new TiptapEditor.RichEditor(this.editorElement, {
            content: this.textarea.value,
            placeholder: this.textarea.getAttribute('placeholder'),
            toolbarButtons: oc.richEditor.resolveButtons({ fieldButtons: this.config.toolbarButtons }),
            buttons: oc.richEditor.buttons,
            useMediaManager: !!this.config.useMediaManager
        });

        this.richEditor.on('change', this.proxy(this.onChange));
        this.updateOutput(this.richEditor.getContent());
    }

    disconnect() {
        this.richEditor.destroy();
        this.richEditor = null;
        this.editorElement = null;
        this.outputElement = null;
        this.textarea = null;
    }

    onChange(html) {
        this.textarea.value = html;
        this.updateOutput(html);
        this.textarea.dispatchEvent(new Event('change', { bubbles: true }));
    }

    updateOutput(html) {
        if (this.outputElement) {
            this.outputElement.textContent = TiptapEditor.formatHtml(html);
        }
    }
});
