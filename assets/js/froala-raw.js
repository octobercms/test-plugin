/*
 * Raw Froala control, initializes Froala directly without the Vue connector
 *
 * Data attributes:
 * - data-control="froala-raw" - enables Froala on the inner textarea
 */

'use strict';

oc.registerControl('froala-raw', class extends oc.ControlBase {
    connect() {
        this.$textarea = $(this.element).find('textarea');

        this.$textarea.froalaEditor({
            toolbarButtons: oc.richEditor.defaultButtons.slice(),
            toolbarSticky: false,
            heightMin: 300
        });
    }

    disconnect() {
        this.$textarea.froalaEditor('destroy');
        this.$textarea = null;
    }
});
