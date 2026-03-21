import WidgetBase from '../../../../../../../modules/dashboard/vuecomponents/dashboard/assets/js/widget-base.js';

export default {
    extends: WidgetBase,
    data: function () {
        return {
        }
    },
    methods: {
        useCustomData: function () {
            return true;
        },

        makeDefaultConfigAndData: function () {
            this.widget.configuration.title = 'My Custom Widget';
        },

        getSettingsConfiguration: function () {
            const result = [{
                property: "title",
                title: "Title",
                type: "string",
            }];

            return result;
        }
    }
};
