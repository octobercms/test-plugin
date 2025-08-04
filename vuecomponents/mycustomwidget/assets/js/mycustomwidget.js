oc.Modules.register('october.test.component.mycustomwidget', function () {
    Vue.component('october-test-vuecomponents-mycustomwidget', {
        extends: Vue.options.components['dashboard-component-dashboard-widget-base'],
        data: function () {
            return {
            }
        },
        methods: {
            useCustomData: function () {
                return true;
            },

            makeDefaultConfigAndData: function () {
                Vue.set(this.widget.configuration, 'title', 'My Custom Widget');
            },

            getSettingsConfiguration: function () {
                const result = [{
                    property: "title",
                    title: "Title",
                    type: "string",
                }];

                return result;
            }
        },
        template: '#october_test_vuecomponents_mycustomwidget'
    });
});
