oc.richEditorRegisterButton('insertCustomThing', {
    title: 'Insert Something',
    icon: '<i class="icon-star"></i>',
    undo: true,
    focus: true,
    refreshOnCallback: true,
    callback: function () {
        this.html.insert('<strong>My Custom Thing!</strong>');
    }
});

oc.richEditorButtons.splice(0, 0, 'insertCustomThing');
