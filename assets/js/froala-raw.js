/*
 * Raw Froala control, initializes Froala directly without the Vue connector
 *
 * Data attributes:
 * - data-control="froala-raw" - enables Froala on the inner textarea
 * - data-toolbar-buttons="bold, italic" - toolbar buttons, the backend default list when omitted
 */

'use strict';

oc.registerControl('froala-raw', class extends oc.ControlBase {
    connect() {
        this.$textarea = $(this.element).find('textarea');

        const toolbarButtons = this.config.toolbarButtons
            ? oc.richEditor.resolveButtons({ fieldButtons: this.config.toolbarButtons })
            : oc.richEditor.defaultButtons.slice();

        const uploadParams = {
            X_OCTOBER_MEDIA_MANAGER_QUICK_UPLOAD: 1,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        // Mirrors the backend form widget, so buttons write the same classes and uploads never reach Froala's demo server
        this.$textarea.froalaEditor({
            toolbarButtons: toolbarButtons,
            toolbarButtonsMD: toolbarButtons,
            toolbarButtonsSM: toolbarButtons,
            toolbarButtonsXS: toolbarButtons,
            toolbarSticky: false,
            heightMin: 300,
            paragraphStyles: {
                'oc-text-gray': 'Gray',
                'oc-text-bordered': 'Bordered',
                'oc-text-spaced': 'Spaced',
                'oc-text-uppercase': 'Uppercase'
            },
            inlineStyles: {
                'oc-class-code': 'Code',
                'oc-class-highlighted': 'Highlighted',
                'oc-class-transparency': 'Transparent'
            },
            tableStyles: {
                'oc-dashed-borders': 'Dashed Borders',
                'oc-alternate-rows': 'Alternate Rows'
            },
            tableCellStyles: {
                'oc-cell-highlighted': 'Highlighted',
                'oc-cell-thick-border': 'Thick'
            },
            imageStyles: {
                'oc-img-rounded': 'Rounded',
                'oc-img-bordered': 'Bordered'
            },
            linkStyles: {
                'oc-link-green': 'Green',
                'oc-link-strong': 'Thick'
            },
            imageUploadURL: window.location,
            fileUploadURL: window.location,
            imageUploadParam: 'file_data',
            fileUploadParam: 'file_data',
            imageUploadParams: uploadParams,
            fileUploadParams: uploadParams
        });
    }

    disconnect() {
        this.$textarea.froalaEditor('destroy');
        this.$textarea = null;
    }
});
